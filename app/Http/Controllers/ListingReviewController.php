<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingReview;
use Illuminate\Http\Request;

class ListingReviewController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        ListingReview::create([
            'listing_id'  => $listing->id,
            'name'        => $data['name'],
            'rating'      => $data['rating'],
            'comment'     => $data['comment'],
            'status'      => ListingReview::STATUS_APPROVED, // guest reviews go pending
            'ip_address'  => $request->ip(),
            'user_agent'  => substr((string) $request->userAgent(), 0, 255),
        ]);

        return back()->with('success', 'Thanks! Your review was submitted and is pending approval.');
    }
}
