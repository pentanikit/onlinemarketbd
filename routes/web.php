<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiteContentController;
use App\Http\Controllers\ListingReviewController;
use App\Http\Controllers\SellerOnboardingController;
use App\Http\Controllers\AuthController;


//Client

Route::get('/', [PageController::class, 'home'])->name('clientHome'); 

Route::prefix('listings')->group(function(){

    Route::get('/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/onboard', [ListingController::class, 'store'])->name('listings.store');
    Route::get('category', [ListingController::class, 'children'])->name('listings.category');
});

Route::get('/seller/dashboard', function () {
    return "Seller Dashboard (Coming soon)";
})->name('welcome.seller');

Route::get('/category/{category:slug}', [CategoryController::class, 'show'])
    ->name('frontend.category.show');

Route::get('/search', [ListingController::class, 'search'])->name('frontend.search');

Route::get('/listing/{listing:slug}', [ListingController::class, 'single_listing'])
    ->name('frontend.listing.show');

Route::post('/listings/{listing:slug}/reviews', [ListingReviewController::class, 'store'])
    ->name('listings.reviews.store');


//admin routes
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function(){

    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
  
    Route::get('listing', [AdminController::class, 'listing'])->name('admin.listing');


    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


    Route::get('/pending-listings', [ListingController::class, 'pending'])->name('listings.pending');
    Route::get('/listings/pending/{listing:id}', [ListingController::class, 'show'])->name('listings.show');

    Route::get('/listings/edit/{listing}', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/update/{listing}', [ListingController::class, 'update'])->name('listings.update');

    Route::post('/listings/{listing}/approve', [ListingController::class, 'approve'])->name('listings.approve');
    Route::post('/listings/{listing}/reject', [ListingController::class, 'reject'])->name('listings.reject');

    Route::get('/home-content', [SiteContentController::class, 'editHome'])->name('home_content.edit');
    Route::post('/home-content', [SiteContentController::class, 'updateHome'])->name('home_content.update');

});


Route::prefix('seller')->group(function () {
    // Stepper page (Blade view)
    Route::get('/onboarding', [SellerOnboardingController::class, 'create'])->name('seller.onboarding');

    // API-like endpoints for step saving (AJAX)
    Route::post('/onboarding/account',  [SellerOnboardingController::class, 'saveAccount'])->name('seller.onboarding.account');
    Route::post('/onboarding/shop',     [SellerOnboardingController::class, 'saveShop'])->name('seller.onboarding.shop');
    Route::post('/onboarding/address',  [SellerOnboardingController::class, 'saveAddress'])->name('seller.onboarding.address');
    Route::post('/onboarding/payout',   [SellerOnboardingController::class, 'savePayout'])->name('seller.onboarding.payout');

    // Final submit (creates/activates shop + logs in seller)
    Route::post('/onboarding/finish',   [SellerOnboardingController::class, 'finish'])->name('seller.onboarding.finish');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



