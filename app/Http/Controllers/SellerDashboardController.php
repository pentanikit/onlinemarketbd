<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SellerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Expecting your onboarding created a shop row linked to user_id
        $shop = DB::table('shops')->where('user_id', $user->id)->first();

        // If your onboarding route name is different, change it here:
        if (!$shop) {
            return redirect()->route('seller.onboarding'); // <-- replace with your existing onboarding route name
        }

        // ---- Safe table detection ----
        $hasOrders   = Schema::hasTable('orders');
        $hasProducts = Schema::hasTable('products');

        // Try to infer "shop column" and "money column" from orders table
        $orderCols = $hasOrders ? Schema::getColumnListing('orders') : [];
        $orderShopCol = $this->pickFirstExisting($orderCols, ['shop_id','seller_id','vendor_id','user_id']);
        $orderTotalCol = $this->pickFirstExisting($orderCols, ['grand_total','total_amount','total','amount','payable']);
        $orderStatusCol = $this->pickFirstExisting($orderCols, ['status','order_status','payment_status']);

        // Basic time windows
        $todayStart = now()->startOfDay();
        $todayEnd   = now()->endOfDay();

        // ---- Stats (fallback safe values) ----
        $stats = [
            'orders_total'   => 0,
            'orders_today'   => 0,
            'orders_pending' => 0,
            'revenue_total'  => 0,
            'revenue_today'  => 0,
            'products_total' => 0,
        ];

        // ---- Orders stats ----
        if ($hasOrders && $orderShopCol) {
            $baseOrders = DB::table('orders')->where($orderShopCol, $shop->id);

            $stats['orders_total'] = (clone $baseOrders)->count();

            $stats['orders_today'] = (clone $baseOrders)
                ->whereBetween('created_at', [$todayStart, $todayEnd])
                ->count();

            if ($orderStatusCol) {
                $stats['orders_pending'] = (clone $baseOrders)
                    ->whereIn($orderStatusCol, ['pending','processing','unpaid'])
                    ->count();
            }

            if ($orderTotalCol) {
                $stats['revenue_total'] = (float) (clone $baseOrders)->sum($orderTotalCol);

                $stats['revenue_today'] = (float) (clone $baseOrders)
                    ->whereBetween('created_at', [$todayStart, $todayEnd])
                    ->sum($orderTotalCol);
            }
        }

        // ---- Product stats ----
        if ($hasProducts) {
            $productCols = Schema::getColumnListing('products');
            $productShopCol = $this->pickFirstExisting($productCols, ['shop_id','seller_id','vendor_id','user_id']);

            if ($productShopCol) {
                $stats['products_total'] = DB::table('products')->where($productShopCol, $shop->id)->count();
            }
        }

        // ---- Recent Orders list ----
        $recentOrders = collect();
        if ($hasOrders && $orderShopCol) {
            $recentOrders = DB::table('orders')
                ->where($orderShopCol, $shop->id)
                ->orderByDesc('id')
                ->limit(10)
                ->get();
        }

        return view('seller.sellerdashboard', [
            'shop'         => $shop,
            'stats'        => $stats,
            'recentOrders' => $recentOrders,
            'orderTotalCol' => $orderTotalCol,   // used in Blade safely
            'orderStatusCol'=> $orderStatusCol,  // used in Blade safely
        ]);
    }

    private function pickFirstExisting(array $columns, array $candidates): ?string
    {
        $set = array_flip($columns);
        foreach ($candidates as $c) {
            if (isset($set[$c])) return $c;
        }
        return null;
    }
}
