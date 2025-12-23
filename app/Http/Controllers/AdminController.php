<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;
use App\Models\City;

class AdminController extends Controller
{
    public function dashboard(){
        return view('backend.dashboard.index');
    }

    public function categories(){
        return view('backend.categories.admin-categories');
    }

public function listing()
{
    $q          = request('q');
    $categoryId = request('category_id');
    $status     = request('status', 'all'); // all|published|pending|draft|rejected
    $cityId     = request('city_id');

    $listings = Listing::query()
        ->with([
            'category:id,name',
            'city:id,name',
            'owner:id,name',
        ])
        ->when($q, function ($query) use ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                   ->orWhere('slug', 'like', "%{$q}%")
                   ->orWhere('phone', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
                   ->orWhereHas('user', function ($u) use ($q) {
                       $u->where('name', 'like', "%{$q}%")
                         ->orWhere('email', 'like', "%{$q}%");
                   });
            });
        })
        ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
        ->when($cityId, fn($query) => $query->where('city_id', $cityId))
        ->when($status !== 'all', fn($query) => $query->where('status', $status))
        ->orderByDesc('updated_at')
        ->paginate(15)
        ->withQueryString();

    $categories = Category::query()
        ->orderBy('name')
        ->get(['id', 'name']);

    $cities = City::query()
        ->orderBy('name')
        ->get(['id', 'name']);

    return view('backend.listing.admin-listing', compact('listings', 'categories', 'cities'));
}
    public function pending_listing(){
        return view('backend.listing.pending-approval');
    }
    public function settings(){
        return view('backend.categories.admin-categories');
    }
 
}
