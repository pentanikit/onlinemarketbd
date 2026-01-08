<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SellerAuthController extends Controller
{
    public function showLogin()
    {
        return view('seller.sellerlogin');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string','min:6'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email or password.',
            ]);
        }

        // Logged in. Now enforce seller role.
        $request->session()->regenerate();

        $user = $request->user();
        if (strtolower((string)($user->role ?? '')) !== 'seller') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'This account is not a seller.',
            ]);
        }

        return redirect()->intended(route('seller.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login');
    }
}
