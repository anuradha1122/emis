<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ForcePasswordResetController extends Controller
{
    public function showForm(Request $request)
    {
        $nic = $request->session()->get('nic');
        if (! $nic) {
            return redirect()->route('login')->withErrors(['nic' => 'Invalid access.']);
        }

        return view('auth.force-reset', ['nic' => $nic]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'nic' => 'required|exists:users,nic',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('nic', $request->nic)->where('active', 1)->firstOrFail();

        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Password updated successfully!');
    }
}
