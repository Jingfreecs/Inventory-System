<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Stock Movement History
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = StockMovement::with('product');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('product', function ($productQuery) use ($search) {
                $productQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $movements = $query->latest()->get();

        return view('stock-movements.index', compact('movements'));
    }


    /*
    |--------------------------------------------------------------------------
    | STOCK OUT
    |--------------------------------------------------------------------------
    */

    public function storeOut(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
            'quantities' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {

            foreach ($request->products as $productId) {

                $product = Product::lockForUpdate()
                    ->findOrFail($productId);

                // Default OUT quantity is 1
                $quantity = $request->input(
                    "quantities.$productId",
                    1
                );

                $quantity = (int) $quantity;

                if ($quantity < 1) {
                    abort(
                        422,
                        "Invalid OUT quantity for {$product->name}."
                    );
                }

                if ($quantity > $product->quantity) {
                    abort(
                        422,
                        "Not enough stock for {$product->name}. Current stock: {$product->quantity}."
                    );
                }

                // Subtract stock
                $product->quantity -= $quantity;
                $product->save();

                // Record movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'OUT',
                    'quantity' => $quantity,
                    'remarks' => 'Stock OUT',
                ]);
            }
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Stock OUT recorded successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | STOCK IN
    |--------------------------------------------------------------------------
    */

    public function createIn()
    {
        $products = Product::orderBy('name')->get();

        return view('stock-movements.stock-in', compact('products'));
    }


    public function storeIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            $product = Product::lockForUpdate()
                ->findOrFail($request->product_id);

            // Add stock
            $product->quantity += $request->quantity;
            $product->save();

            // Record movement
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'IN',
                'quantity' => $request->quantity,
                'remarks' => $request->remarks,
            ]);
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Stock IN recorded successfully.');
    }
}
