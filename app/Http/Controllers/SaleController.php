<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Sales History
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $sales = Sale::with('items.product')
            ->latest()
            ->get();

        return view('sales.index', compact('sales'));
    }


    /*
    |--------------------------------------------------------------------------
    | New Sale
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $products = Product::where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        $cart = session('cart', []);

        $cartProducts = [];

        foreach ($cart as $productId => $item) {

            $product = Product::find($productId);

            if ($product) {
                $cartProducts[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ];
            }
        }

        $total = collect($cartProducts)->sum('subtotal');

        return view('sales.create', compact(
            'products',
            'cartProducts',
            'total'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Add Product To Cart
    |--------------------------------------------------------------------------
    */

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = session('cart', []);

        $currentQuantity = $cart[$product->id]['quantity'] ?? 0;

        $newQuantity = $currentQuantity + $request->quantity;

        if ($newQuantity > $product->quantity) {
            return back()->withErrors([
                'quantity' => "Not enough stock for {$product->name}. Current stock: {$product->quantity}."
            ]);
        }

        $cart[$product->id] = [
            'quantity' => $newQuantity,
        ];

        session(['cart' => $cart]);

        return redirect()
            ->route('sales.create')
            ->with('success', 'Product added to cart.');
    }




    public function removeFromCart(int $productId)
    {
        $cart = session('cart', []);

        unset($cart[$productId]);

        session(['cart' => $cart]);

        return redirect()->route('sales.create');
    }




    public function clearCart()
    {
        session()->forget('cart');

        return redirect()
            ->route('sales.create')
            ->with('success', 'Cart cleared.');
    }


    public function checkout(Request $request)
    {
        $request->validate([
            'cash_received' => 'required|numeric|min:0',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->withErrors([
                'cart' => 'Your cart is empty.'
            ]);
        }

        DB::transaction(function () use ($request, $cart) {

            $total = 0;

            $saleItems = [];

            foreach ($cart as $productId => $item) {

                $product = Product::lockForUpdate()
                    ->findOrFail($productId);

                $quantity = (int) $item['quantity'];

                if ($quantity > $product->quantity) {
                    abort(
                        422,
                        "Not enough stock for {$product->name}."
                    );
                }

                $price = $product->price;

                $subtotal = $price * $quantity;

                $total += $subtotal;

                $saleItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }


            if ($request->cash_received < $total) {
                abort(
                    422,
                    'Cash received is not enough to complete the sale.'
                );
            }


            $change = $request->cash_received - $total;


            $sale = Sale::create([
                'invoice_number' => 'INV-' . date('YmdHis') . '-' . random_int(100, 999),

                'total_amount' => $total,

                'cash_received' => $request->cash_received,

                'change_amount' => $change,
            ]);


            foreach ($saleItems as $item) {

                $product = $item['product'];

                SaleItem::create([
                    'sale_id' => $sale->id,

                    'product_id' => $product->id,

                    'quantity' => $item['quantity'],

                    'price' => $item['price'],

                    'subtotal' => $item['subtotal'],
                ]);


                // Deduct inventory
                $product->quantity -= $item['quantity'];

                $product->save();
            }
        });


        session()->forget('cart');


        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale completed successfully.');
    }
        public function show(Sale $sale)
{
    $sale->load('items.product');

    return view('sales.show', compact('sale'));
}

public function invoice(Sale $sale)
{
    $sale->load('items.product');

    return view('sales.invoice', compact('sale'));
}
}
