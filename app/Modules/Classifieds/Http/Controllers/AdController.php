<?php

namespace App\Modules\Classifieds\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Classifieds\Models\ClassifiedCategory;
use App\Modules\Classifieds\Http\Requests\StoreAdRequest;
use App\Modules\Classifieds\Services\ClassifiedOnboardingService;
use App\Modules\Classifieds\Models\ClassifiedAd;

class AdController extends Controller
{
    public function create()
    {
        $categories = ClassifiedCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('classifieds::ads.create', compact('categories'));
    }

    public function store(
        StoreAdRequest $request,
        ClassifiedOnboardingService $service
    ) {
        $category = ClassifiedCategory::query()
            ->where('id', $request->category_id)
            ->where('is_active', true)
            ->firstOrFail();

        $ad = $service->createAdWithUser($request->validated(), $category);

        return redirect()
            ->route('classifieds.ads.show', $ad->slug)
            ->with('success', 'Your ad has been submitted successfully.');
    }


    public function show(ClassifiedAd $ad)
    {
        $ad->increment('views_count');

        $ad->load([
            'images',
            'category',
            'adUser',
        ]);

        return view('classifieds::ads.show', compact('ad'));
    }
}