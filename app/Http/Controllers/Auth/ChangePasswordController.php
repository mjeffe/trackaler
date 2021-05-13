<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/*
 * Mysteriously, Laravel's Breeze package does not implement this basic
 * feature. This is my custom change password controller.
 */
class ChangePasswordController extends Controller
{
    /**
     * Display the change password view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request) {
        return view('auth.change-password', ['request' => $request]);
    }

    /**
     * Handle an incoming change password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Incorrect password']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        // log user out and redirect to login page
        $this->logout($request);

        return redirect()->route('login')->with('status', __('Successfully changed password'));
    }

    // copied from AuthenticatedSessionController->logout()
    protected function logout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
