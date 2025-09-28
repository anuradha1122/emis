<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/login",
 *     summary="Authenticate user and return token",
 *     tags={"Authentication"},
 *     @OA\Parameter(
 *         name="nic",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string", example="123456789V")
 *     ),
 *     @OA\Parameter(
 *         name="password",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string", example="password123")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User authenticated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="1|longauthtokenstring"),
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="nic", type="string", example="123456789V"),
 *                 @OA\Property(property="active", type="integer", example=1)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Invalid credentials")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="User is inactive",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="User is inactive")
 *         )
 *     )
 * )
 */


class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'nic' => 'required|unique:users',
    //         'password' => 'required|min:6',
    //     ]);

    //     $user = User::create([
    //         'nic' => $request->nic,
    //         'password' => bcrypt($request->password),
    //         'active' => 1, // Default active = 1
    //     ]);

    //     return response()->json(['message' => 'User registered successfully'], 201);
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'nic' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('nic', $request->nic)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json(['error' => 'Invalid credentials'], 401);
    //     }

    //     if ($user->active == 0) {
    //         return response()->json(['error' => 'User is inactive'], 403);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'token' => $token,
    //         'user' => $user,
    //     ], 200);
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'nic' => 'required',
    //         'password' => 'required',
    //     ]);

    //     // Fetch user with user_in_services
    //     $user = DB::table('users')
    //         ->leftJoin('user_in_services', 'users.id', '=', 'user_in_services.userId')
    //         ->where('users.nic', $request->nic)
    //         ->select(
    //             'users.id',
    //             'users.nic',
    //             'users.password',
    //             'users.active',
    //             'user_in_services.id as userServiceId',
    //             'user_in_services.serviceId'
    //         )
    //         ->get(); // Fetch all matching records

    //     // Check if user exists
    //     if ($user->isEmpty() || !Hash::check($request->password, $user[0]->password)) {
    //         return response()->json(['error' => 'Invalid credentials'], 401);
    //     }

    //     // Check if user is active
    //     if ($user[0]->active == 0) {
    //         return response()->json(['error' => 'User is inactive'], 403);
    //     }

    //     // Get the first user's model to generate token
    //     $userModel = User::find($user[0]->id);
    //     $token = $userModel->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'token' => $token,
    //         'user' => [
    //             'id' => $user[0]->id,
    //             'nic' => $user[0]->nic,
    //             'active' => $user[0]->active,
    //             'userInServices' => $user->map(function ($service) {
    //                 return [
    //                     'id' => $service->userServiceId,
    //                     'userId' => $service->id,
    //                     'serviceId' => $service->serviceId,
    //                 ];
    //             }),
    //         ],
    //     ], 200);
    // }


    public function login(Request $request)
    {
        $request->validate([
            'nic' => 'required',
            'password' => 'required',
        ]);

        // Fetch user with user_in_services, user_service_appointments and work_places
        $user = DB::table('users')
            ->leftJoin('user_in_services', 'users.id', '=', 'user_in_services.userId')
            ->leftJoin('user_service_appointments', function ($join) {
                $join->on('user_in_services.id', '=', 'user_service_appointments.userServiceId')
                    ->where('user_service_appointments.current', 1); // Only current appointments
            })
            ->leftJoin('work_places', 'user_service_appointments.workPlaceId', '=', 'work_places.id')
            ->where('users.nic', $request->nic)
            ->select(
                'users.id',
                'users.nic',
                'users.password',
                'users.active',
                'user_in_services.id as userServiceId',
                'user_in_services.serviceId',
                'user_service_appointments.id as appointmentId',
                'user_service_appointments.workPlaceId',
                'work_places.name as workPlaceName',
                'work_places.categoryId'
            )
            ->get(); // Fetch all matching records

        // Check if user exists
        if ($user->isEmpty() || !Hash::check($request->password, $user[0]->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Check if user is active
        if ($user[0]->active == 0) {
            return response()->json(['error' => 'User is inactive'], 403);
        }

        // Get the first user's model to generate token
        $userModel = User::find($user[0]->id);
        $token = $userModel->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user[0]->id,
                'nic' => $user[0]->nic,
                'active' => $user[0]->active,
                'userInServices' => $user->map(function ($service) {
                    return [
                        'userServiceId' => $service->userServiceId,
                        'serviceId' => $service->serviceId,
                        'appointmentId' => $service->appointmentId,
                        'workPlaceId' => $service->workPlaceId,
                        'workPlace' => $service->workPlaceName,
                        'categoryId' => $service->categoryId,
                    ];
                }),
            ],
        ], 200);
    }



    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout the authenticated user",
     *     description="Logs out the user by revoking all tokens.",
     *     operationId="logoutUser",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

}
