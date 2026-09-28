<?php

namespace App\Http\Controllers;

use App\Models\Product;

class LowStockController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->orderBy('quantity')
            ->get();

        return view('low-stock.index', compact('products'));
    }
}
