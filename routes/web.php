<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;



//Client

Route::get('/', [PageController::class, 'home'])->name('clientHome'); 

Route::prefix('listings')->group(function(){

    Route::get('/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/onboard', [ListingController::class, 'store'])->name('listings.store');
    Route::get('category', [ListingController::class, 'children'])->name('listings.category');
});



Route::get('/category/{category:slug}', [CategoryController::class, 'show'])
    ->name('frontend.category.show');

Route::get('/search', [ListingController::class, 'search'])->name('frontend.search');

Route::get('/listing/{listing:slug}', [ListingController::class, 'show'])
    ->name('frontend.listing.show');


//admin routes
Route::prefix('admin')->group(function(){

   Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
  
   Route::get('listing', [AdminController::class, 'listing'])->name('admin.listing');
//    Route::get('pending-listing', [AdminController::class, 'pending_listing'])->name('admin.pending-listing');



    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


    Route::get('/listings/pending', [ListingController::class, 'pending'])->name('listings.pending');
    Route::get('/listings/pending/{listing}', [ListingController::class, 'show'])->name('listings.show');

    Route::post('/listings/{listing}/approve', [ListingController::class, 'approve'])->name('listings.approve');
    Route::post('/listings/{listing}/reject', [ListingController::class, 'reject'])->name('listings.reject');

});



