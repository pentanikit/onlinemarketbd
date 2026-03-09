<?php

namespace App\Modules\Classifieds\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Classifieds\Models\ClassifiedAd;

class DashboardController extends Controller
{
    public function myAds()
    {
        $userId = session(config('classifieds.session_key', 'classified_ad_user_id'));

        $ads = ClassifiedAd::with(['images', 'category'])
            ->where('classified_ad_user_id', $userId)
            ->latest()
            ->get();

        return view('classifieds::ads.my-ads', compact('ads'));
    }
}