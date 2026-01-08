<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSeller
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('seller.login');
        }

        if (strtolower((string) ($user->role ?? '')) !== 'seller') {
            abort(403, 'Seller access only.');
        }

        return $next($request);
    }
}

