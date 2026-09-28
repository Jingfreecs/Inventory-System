<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalCategories = Category::count();

        $totalStock = Product::sum('quantity');

        $lowStock = Product::whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )->count();

        // Today's sales amount
        $todaySales = Sale::whereDate(
            'created_at',
            today()
        )->sum('total_amount');

        // Number of sales transactions today
        $todayTransactions = Sale::whereDate(
            'created_at',
            today()
        )->count();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalStock',
            'lowStock',
            'todaySales',
            'todayTransactions'
        ));
    }
}
