<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $recentOrders = Order::latest()->take(5)->get();


        return view('admin.dashboard', [
            'totalOrders' => Order::count(),
            'totalSales'  => Order::sum('total'),
            'customers'   => User::where('role', 'cliente')->count(),
            'products'    => Product::where('activo', 1)->count(),
            'recentOrders' => $recentOrders,
        ]);
    }
}
