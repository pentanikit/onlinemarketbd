<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiteContentController;
use App\Http\Controllers\ListingReviewController;
use App\Http\Controllers\SellerOnboardingController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerProductsController;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;


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

        // Seller login
    Route::get('/seller-login', [SellerAuthController::class, 'showLogin'])->name('seller.login');
    Route::post('/seller-signin', [SellerAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [SellerAuthController::class, 'logout'])->name('seller.logout');


    Route::middleware(['auth', 'seller'])->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');
        Route::get('/products/create', [SellerProductsController::class, 'create'])->name('products.create');
        Route::post('/products', [SellerProductsController::class, 'store'])->name('products.store');
    });


    // Final submit (creates/activates shop + logs in seller)
    Route::post('/onboarding/finish',   [SellerOnboardingController::class, 'finish'])->name('seller.onboarding.finish');
});


Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shops.show');

Route::get('/product/{slug}', [SellerProductsController::class, 'show'])
    ->name('product.view');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



