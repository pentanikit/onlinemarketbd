<?php

namespace App\Modules\Classifieds\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClassifiedAuth
{
    public function handle(Request $request, Closure $next)
    {
        $sessionKey = config('classifieds.session_key', 'classified_ad_user_id');

        if (!session()->has($sessionKey)) {
            return redirect()->route('classifieds.categories.index')
                ->with('error', 'Please post an ad first or access your account through your ad session.');
        }

        return $next($request);
    }
}