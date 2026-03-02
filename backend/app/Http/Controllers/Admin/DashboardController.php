<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShopManager;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::query()->count(),
            'totalCategories' => Category::query()->count(),
            'totalOrders' => Order::query()->count(),
            'totalManagers' => ShopManager::query()->count(),
            'revenue' => Order::query()->sum('total_amount'),
            'recentOrders' => Order::query()->with('manager:id,name')->latest()->take(8)->get(),
            'lowStockProducts' => Product::query()->where('inventory', '<=', 10)->orderBy('inventory')->take(8)->get()
        ]);
    }
}
