<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerOnboardingController extends Controller
{
    public function create()
    {
        return view('seller.onboarding');
    }

    /**
     * Step 1: Save account info in session
     */
    public function saveAccount(Request $request)
    {
        $data = $request->validate([
            'fullName'   => ['required', 'string', 'max:120'],
            'phone'      => ['required', 'regex:/^01\d{9}$/'],
            'email'      => ['nullable', 'email', 'max:190'],
            'password'   => ['required', 'string', 'min:6'],
            'agreeTerms' => ['required', 'in:1,true,yes,on'],
        ], [
            'phone.regex' => 'Phone must be a valid BD number (01XXXXXXXXX).',
        ]);

        if (!empty($data['email']) && User::where('email', $data['email'])->exists()) {
            return response()->json([
                'ok' => false,
                'message' => 'Email already used.',
            ], 422);
        }

        if (User::where('phone', $data['phone'])->exists()) {
            return response()->json([
                'ok' => false,
                'message' => 'Phone already used.',
            ], 422);
        }

        session()->put('seller_onboarding.account', [
            'name'     => $data['fullName'],
            'phone'    => $data['phone'],
            'email'    => $data['email'] ?? null,
            'password' => $data['password'],
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Account step saved successfully.',
        ]);
    }

    /**
     * Step 2: Save shop info in session
     */
    public function saveShop(Request $request)
    {
        $data = $request->validate([
            'shopName'     => ['required', 'string', 'max:160'],
            'category'     => ['required', 'string', 'max:80'],
            'shopSlug'     => ['required', 'alpha_dash', 'max:80'],
            'supportPhone' => ['nullable', 'regex:/^01\d{9}$/'],
            'shopDesc'     => ['nullable', 'string', 'max:2000'],
            'logo'         => ['nullable', 'image', 'max:2048'],
            'banner'       => ['nullable', 'image', 'max:4096'],
        ], [
            'supportPhone.regex' => 'Support phone must be a valid BD number (01XXXXXXXXX).',
        ]);

        $slug = Str::slug($data['shopSlug']);

        if (Shop::where('slug', $slug)->exists()) {
            return response()->json([
                'ok' => false,
                'message' => 'This shop URL is already taken.',
            ], 422);
        }

        $oldShop = session('seller_onboarding.shop', []);

        $logoPath = $oldShop['logo_path'] ?? null;
        $bannerPath = $oldShop['banner_path'] ?? null;

        if ($request->hasFile('logo')) {
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('temp/shops', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($bannerPath && Storage::disk('public')->exists($bannerPath)) {
                Storage::disk('public')->delete($bannerPath);
            }
            $bannerPath = $request->file('banner')->store('temp/shops', 'public');
        }

        session()->put('seller_onboarding.shop', [
            'name'          => $data['shopName'],
            'category'      => $data['category'],
            'slug'          => $slug,
            'support_phone' => $data['supportPhone'] ?? null,
            'description'   => $data['shopDesc'] ?? null,
            'logo_path'     => $logoPath,
            'banner_path'   => $bannerPath,
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Shop step saved successfully.',
            'logo_path' => $logoPath,
            'banner_path' => $bannerPath,
        ]);
    }

    /**
     * Final step: Create seller + shop
     */
    public function finish(Request $request)
    {
        $request->validate([
            'confirmInfo' => ['required', 'in:1,true,yes,on'],
        ]);

        $account = session('seller_onboarding.account');
        $shop = session('seller_onboarding.shop');

        if (!$account || !$shop) {
            return response()->json([
                'ok' => false,
                'message' => 'Onboarding data missing. Please complete all required steps.',
            ], 422);
        }

        if (!empty($account['email']) && User::where('email', $account['email'])->exists()) {
            return response()->json([
                'ok' => false,
                'message' => 'Email already used.',
            ], 422);
        }

        if (User::where('phone', $account['phone'])->exists()) {
            return response()->json([
                'ok' => false,
                'message' => 'Phone already used.',
            ], 422);
        }

        if (Shop::where('slug', $shop['slug'])->exists()) {
            return response()->json([
                'ok' => false,
                'message' => 'Shop URL already taken.',
            ], 422);
        }

        $createdUser = null;
        $createdShop = null;

        DB::transaction(function () use (&$createdUser, &$createdShop, $account, $shop) {
            $createdUser = User::create([
                'name'     => $account['name'],
                'email'    => $account['email'],
                'phone'    => $account['phone'],
                'password' => Hash::make($account['password']),
                'role'     => 'seller',
            ]);

            $logoPath = $this->moveTempToPermanent($shop['logo_path'] ?? null);
            $bannerPath = $this->moveTempToPermanent($shop['banner_path'] ?? null);

            $createdShop = Shop::create([
                'user_id'       => $createdUser->id,
                'name'          => $shop['name'],
                'category'      => $shop['category'],
                'slug'          => $shop['slug'],
                'support_phone' => $shop['support_phone'] ?? null,
                'description'   => $shop['description'] ?? null,
                'logo_path'     => $logoPath,
                'banner_path'   => $bannerPath,
                'status'        => 'pending',
                'onboarded_at'  => now(),
            ]);
        });

        Auth::login($createdUser);

        session()->forget('seller_onboarding');

        return response()->json([
            'ok' => true,
            'message' => 'Seller account and shop created successfully.',
            'shop_url' => url('/shop/' . $createdShop->slug),
            'redirect' => url('/seller/dashboard'),
        ]);
    }

    private function moveTempToPermanent(?string $tempPath): ?string
    {
        if (!$tempPath) {
            return null;
        }

        if (!Storage::disk('public')->exists($tempPath)) {
            return null;
        }

        $filename = basename($tempPath);
        $newPath = 'shops/media/' . $filename;

        Storage::disk('public')->move($tempPath, $newPath);

        return $newPath;
    }
}