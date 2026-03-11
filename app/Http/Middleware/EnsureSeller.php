<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSeller
{
    public function handle(Request $request, Closure $next)
    {
        $seller = Auth::guard('classified_ad')->user();

        if (!$seller) {
            return redirect()->route('seller.login');
        }

        return $next($request);
    }
}

