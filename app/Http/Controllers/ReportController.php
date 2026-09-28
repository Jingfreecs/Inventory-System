<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalProducts = Product::count();

        $totalQuantity = Product::sum('quantity');

        $lowStock = Product::whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )->count();

        $totalStockIn = StockMovement::where('type', 'IN')
            ->sum('quantity');

        $totalStockOut = StockMovement::where('type', 'OUT')
            ->sum('quantity');

        $movements = StockMovement::with('product')
            ->latest()
            ->get();

        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SALES / INVOICE REPORT
        |--------------------------------------------------------------------------
        */

        $salesQuery = Sale::with('items.product');

        // Quick date filter
        if ($request->filled('period')) {

            switch ($request->period) {

                case 'today':
                    $salesQuery->whereDate(
                        'created_at',
                        today()
                    );
                    break;

                case 'week':
                    $salesQuery->whereBetween(
                        'created_at',
                        [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ]
                    );
                    break;

                case 'month':
                    $salesQuery->whereMonth(
                        'created_at',
                        now()->month
                    )->whereYear(
                        'created_at',
                        now()->year
                    );
                    break;
            }
        }

        // Custom date range
        if ($request->filled('from_date')) {
            $salesQuery->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->filled('to_date')) {
            $salesQuery->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        $sales = $salesQuery
            ->latest()
            ->get();

        $totalSales = $sales->sum('total_amount');

        $totalTransactions = $sales->count();

        return view('reports.index', compact(
            'totalProducts',
            'totalQuantity',
            'lowStock',
            'totalStockIn',
            'totalStockOut',
            'movements',
            'products',
            'sales',
            'totalSales',
            'totalTransactions'
        ));
    }
}
