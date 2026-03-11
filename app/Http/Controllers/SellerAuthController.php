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
            'login'    => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $remember = (bool) $request->boolean('remember');

        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (!Auth::guard('classified_ad')->attempt([
            $field => $data['login'],
            'password' => $data['password'],
            'status' => 'active',
        ], $remember)) {
            throw ValidationException::withMessages([
                'login' => 'Invalid email/phone or password.',
            ]);
        }

        $request->session()->regenerate();

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
