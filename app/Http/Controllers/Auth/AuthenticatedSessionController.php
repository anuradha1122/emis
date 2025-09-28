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
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['redirect'])) {
                return redirect($errors['redirect'][0]);
            }
            throw $e;
        }

        $request->session()->regenerate();

        Auth::user()->load([
            'currentService.currentAppointment.workPlace.school.office',
            'currentService.currentAppointment.workPlace.office',
            'currentService.currentAppointment.workPlace.ministry.office',
            'currentService.currentAppointment.currentPosition'
        ]);
        return redirect()->intended('/dashboard'); // or '/home' or whatever
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
