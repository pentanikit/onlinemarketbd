<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopAddress;
use App\Models\ShopPayoutMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SellerOnboardingController extends Controller
{
    public function create()
    {
        // Return your stepper view. You can paste your HTML into a Blade view.
        return view('seller.onboarding');
    }

    /**
     * Step 1: Create seller account draft in session
     * We do NOT create DB user yet (optional). We can create at finish.
     * But we validate now and store in session.
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

        // email/phone uniqueness check (soft check now)
        if (!empty($data['email']) && User::where('email', $data['email'])->exists()) {
            return response()->json(['ok' => false, 'message' => 'Email already used.'], 422);
        }
        if (User::where('phone', $data['phone'])->exists()) {
            return response()->json(['ok' => false, 'message' => 'Phone already used.'], 422);
        }

        session()->put('seller_onboarding.account', [
            'name' => $data['fullName'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'password' => $data['password'], // will hash at finish
        ]);

        return response()->json(['ok' => true]);
    }

    /**
     * Step 2: Shop info (stored in session)
     */
    public function saveShop(Request $request)
    {
        $data = $request->validate([
            'shopName'     => ['required', 'string', 'max:160'],
            'category'     => ['required', 'string', 'max:80'],
            'shopSlug'     => ['required', 'alpha_dash', 'max:80'],
            'supportPhone' => ['nullable', 'regex:/^01\d{9}$/'],
            'shopDesc'     => ['required', 'string', 'max:2000'],
            'logo'         => ['nullable', 'image', 'max:2048'],
            'banner'       => ['nullable', 'image', 'max:4096'],
        ], [
            'supportPhone.regex' => 'Support phone must be a valid BD number (01XXXXXXXXX).',
        ]);

        // slug uniqueness check now
        if (Shop::where('slug', $data['shopSlug'])->exists()) {
            return response()->json(['ok' => false, 'message' => 'This shop URL is already taken.'], 422);
        }

        // Store uploaded files temporarily (so user can step around)
        $logoPath = null;
        $bannerPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('temp/shops', 'public');
        }
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('temp/shops', 'public');
        }

        session()->put('seller_onboarding.shop', [
            'name' => $data['shopName'],
            'category' => $data['category'],
            'slug' => Str::slug($data['shopSlug']),
            'support_phone' => $data['supportPhone'] ?? null,
            'description' => $data['shopDesc'],
            'logo_path' => $logoPath,
            'banner_path' => $bannerPath,
        ]);

        return response()->json([
            'ok' => true,
            'logo_path' => $logoPath,
            'banner_path' => $bannerPath,
        ]);
    }

    /**
     * Step 3: Address
     */
    public function saveAddress(Request $request)
    {
        $data = $request->validate([
            'division'   => ['required', 'string', 'max:60'],
            'district'   => ['required', 'string', 'max:100'],
            'address'    => ['required', 'string', 'max:2000'],
            'postal'     => ['nullable', 'string', 'max:20'],
            'pickupNotes'=> ['nullable', 'string', 'max:255'],
        ]);

        session()->put('seller_onboarding.address', [
            'division' => $data['division'],
            'district' => $data['district'],
            'address' => $data['address'],
            'postal_code' => $data['postal'] ?? null,
            'pickup_notes' => $data['pickupNotes'] ?? null,
        ]);

        return response()->json(['ok' => true]);
    }

    /**
     * Step 4: Payout
     */
    public function savePayout(Request $request)
    {
        $data = $request->validate([
            'payoutMethod' => ['required', Rule::in(['bkash', 'nagad', 'bank'])],
            'payoutNumber' => ['required', 'string', 'max:120'],
            'payoutName'   => ['required', 'string', 'max:120'],
            'bankInfo'     => ['nullable', 'string', 'max:190'],
        ]);

        session()->put('seller_onboarding.payout', [
            'method' => $data['payoutMethod'],
            'account_number' => $data['payoutNumber'],
            'account_name' => $data['payoutName'],
            'bank_info' => $data['bankInfo'] ?? null,
        ]);

        return response()->json(['ok' => true]);
    }

    /**
     * Finish: create seller user + shop + address + payout (transaction)
     */
    public function finish(Request $request)
    {
        $request->validate([
            'confirmInfo' => ['required', 'in:1,true,yes,on'],
        ]);

        $account = session('seller_onboarding.account');
        $shop    = session('seller_onboarding.shop');
        $address = session('seller_onboarding.address');
        $payout  = session('seller_onboarding.payout');

        if (!$account || !$shop || !$address || !$payout) {
            return response()->json([
                'ok' => false,
                'message' => 'Onboarding data missing. Please complete all steps.',
            ], 422);
        }

        // Re-check uniqueness at final time
        if (!empty($account['email']) && User::where('email', $account['email'])->exists()) {
            return response()->json(['ok' => false, 'message' => 'Email already used.'], 422);
        }
        if (User::where('phone', $account['phone'])->exists()) {
            return response()->json(['ok' => false, 'message' => 'Phone already used.'], 422);
        }
        if (Shop::where('slug', $shop['slug'])->exists()) {
            return response()->json(['ok' => false, 'message' => 'Shop URL already taken.'], 422);
        }

        $createdUser = null;
        $createdShop = null;

        DB::transaction(function () use (&$createdUser, &$createdShop, $account, $shop, $address, $payout) {

            $createdUser = User::create([
                'name' => $account['name'],
                'email' => $account['email'],
                'phone' => $account['phone'],
                'password' => Hash::make($account['password']),
                'role' => 'seller',
            ]);

            // Move temp files to permanent folder (if any)
            $logoPath = $this->moveTempToPermanent($shop['logo_path'] ?? null);
            $bannerPath = $this->moveTempToPermanent($shop['banner_path'] ?? null);

            $createdShop = Shop::create([
                'user_id' => $createdUser->id,
                'name' => $shop['name'],
                'category' => $shop['category'],
                'slug' => $shop['slug'],
                'support_phone' => $shop['support_phone'] ?? null,
                'description' => $shop['description'] ?? null,
                'logo_path' => $logoPath,
                'banner_path' => $bannerPath,
                'status' => 'pending',
                'onboarded_at' => now(),
            ]);

            ShopAddress::create([
                'shop_id' => $createdShop->id,
                ...$address,
            ]);

            ShopPayoutMethod::create([
                'shop_id' => $createdShop->id,
                'method' => $payout['method'],
                'account_number' => $payout['account_number'],
                'account_name' => $payout['account_name'],
                'bank_info' => $payout['bank_info'] ?? null,
                'is_default' => true,
            ]);
        });

        // login seller immediately
        Auth::login($createdUser);

        // clear onboarding session
        session()->forget('seller_onboarding');

        return response()->json([
            'ok' => true,
            'message' => 'Seller account and shop created successfully.',
            'shop_url' => url('/shop/' . $createdShop->slug),
            'redirect' => url('/seller/dashboard'), // change to your dashboard route
        ]);
    }

    private function moveTempToPermanent(?string $tempPath): ?string
    {
        if (!$tempPath) return null;

        // tempPath like: temp/shops/abc.jpg in 'public' disk
        if (!Storage::disk('public')->exists($tempPath)) {
            return null;
        }

        $filename = basename($tempPath);
        $newPath = 'shops/media/' . $filename;

        Storage::disk('public')->move($tempPath, $newPath);

        return $newPath;
    }
}
