<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     try {
    //         $request->authenticate();
    //     } catch (ValidationException $e) {
    //         $errors = $e->errors();
    //         if (isset($errors['redirect'])) {
    //             return redirect($errors['redirect'][0]);
    //         }
    //         throw $e;
    //     }

    //     $request->session()->regenerate();

    //     Auth::user()->load([
    //         'currentService.currentAppointment.workPlace.school.office',
    //         'currentService.currentAppointment.workPlace.office',
    //         'currentService.currentAppointment.workPlace.ministry.office',
    //         'currentService.currentAppointment.currentPosition'
    //     ]);
    //     return redirect()->intended('/dashboard'); // or '/home' or whatever
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('nic', 'password');

        // Try to find user by NIC
        $user = \App\Models\User::where('nic', $credentials['nic'])
        ->where('active', 1)
        ->first();

        if ($user) {
            $defaultPassword = substr($user->nic, 0, 6);

            // If user tries to log in with default NIC-based password
            if ($credentials['password'] === $defaultPassword) {
                return redirect()->route('password.force')
                    ->with('nic', $user->nic)
                    ->with('message', 'You must reset your password before logging in.');
            }
        }

        // Proceed with normal authentication
        try {
            $request->authenticate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }

        $request->session()->regenerate();

        // Load relationships if needed
        Auth::user()->load([
            'currentService.currentAppointment.workPlace.school.office',
            'currentService.currentAppointment.workPlace.office',
            'currentService.currentAppointment.workPlace.ministry.office',
            'currentService.currentAppointment.currentPosition'
        ]);

        return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
