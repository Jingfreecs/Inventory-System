<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Inventory Reports - Inventory System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand"
           href="{{ route('dashboard') }}">
            📦 Inventory System
        </a>

        <div>

            <a href="{{ route('dashboard') }}"
               class="btn btn-outline-light btn-sm">
                Dashboard
            </a>

            <a href="{{ route('products.index') }}"
               class="btn btn-outline-light btn-sm">
                Products
            </a>

            <a href="{{ route('categories.index') }}"
               class="btn btn-outline-light btn-sm">
                Categories
            </a>

            <a href="{{ route('stock-movements.index') }}"
               class="btn btn-outline-light btn-sm">
                Stock Movements
            </a>

            <a href="{{ route('low-stock.index') }}"
               class="btn btn-outline-warning btn-sm">
                Low Stock
            </a>

        </div>

    </div>

</nav>


<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>📊 Inventory Reports</h2>

            <p class="text-muted">
                Overview of inventory and stock movements.
            </p>

        </div>

        <button
            onclick="window.print()"
            class="btn btn-secondary">
            🖨 Print Report
        </button>

    </div>


    {{-- SUMMARY CARDS --}}

    <div class="row g-3 mb-4">

        <div class="col-md-3">

            <div class="card text-bg-primary">

                <div class="card-body">

                    <h6>Total Products</h6>

                    <h2>
                        {{ $totalProducts }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card text-bg-success">

                <div class="card-body">

                    <h6>Total Stock</h6>

                    <h2>
                        {{ $totalQuantity }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card text-bg-info">

                <div class="card-body">

                    <h6>Total Stock IN</h6>

                    <h2>
                        {{ $totalStockIn }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card text-bg-danger">

                <div class="card-body">

                    <h6>Total Stock OUT</h6>

                    <h2>
                        {{ $totalStockOut }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    {{-- LOW STOCK WARNING --}}

    @if($lowStock > 0)

        <div class="alert alert-warning">

            ⚠️ There are
            <strong>{{ $lowStock }}</strong>
            product(s) currently at or below their reorder level.

            <a href="{{ route('low-stock.index') }}"
               class="alert-link">
                View Low Stock
            </a>

        </div>

    @else

        <div class="alert alert-success">

            ✅ All products are currently above their reorder levels.

        </div>

    @endif


    {{-- PRODUCT INVENTORY SUMMARY --}}

    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Product Inventory Summary
            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>

                            <th>Product Code</th>

                            <th>Product</th>

                            <th>Category</th>

                            <th>Price</th>

                            <th>Quantity</th>

                            <th>Reorder Level</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($products as $product)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $product->product_code }}
                                </td>

                                <td>
                                    {{ $product->name }}
                                </td>

                                <td>
                                    {{ $product->category->name ?? 'No Category' }}
                                </td>

                                <td>
                                    ₱{{ number_format($product->price, 2) }}
                                </td>

                                <td>
                                    {{ $product->quantity }}
                                </td>

                                <td>
                                    {{ $product->reorder_level }}
                                </td>

                                <td>

                                    @if($product->quantity <= $product->reorder_level)

                                        <span class="badge bg-danger">
                                            Low Stock
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            In Stock
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- STOCK MOVEMENT HISTORY --}}

    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Stock Movement History
            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>

                            <th>Date</th>

                            <th>Product</th>

                            <th>Type</th>

                            <th>Quantity</th>

                            <th>Remarks</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($movements as $movement)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $movement->created_at->format('M d, Y h:i A') }}
                                </td>

                                <td>
                                    {{ $movement->product->name ?? 'Deleted Product' }}
                                </td>

                                <td>

                                    @if($movement->type === 'IN')

                                        <span class="badge bg-success">
                                            IN
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            OUT
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $movement->quantity }}
                                </td>

                                <td>
                                    {{ $movement->remarks ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center">

                                    No stock movements recorded.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <div class="card shadow-sm mt-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Sales / Invoice Report</h5>
    </div>

    <div class="card-body">

        <div class="row mb-4">
            <div class="col-md-6">
                <strong>Total Sales:</strong>
                ₱{{ number_format($totalSales, 2) }}
            </div>

            <div class="col-md-6">
                <strong>Total Transactions:</strong>
                {{ $totalTransactions }}
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Cash</th>
                        <th>Change</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sales as $sale)

                        <tr>
                            <td>
                                {{ $sale->invoice_number }}
                            </td>

                            <td>
                                {{ $sale->created_at->format('M d, Y h:i A') }}
                            </td>

                            <td>
                                @foreach($sale->items as $item)
                                    {{ $item->product->name }}
                                    × {{ $item->quantity }}

                                    @if(!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </td>

                            <td>
                                ₱{{ number_format($sale->total_amount, 2) }}
                            </td>

                            <td>
                                ₱{{ number_format($sale->cash_received, 2) }}
                            </td>

                            <td>
                                ₱{{ number_format($sale->change_amount, 2) }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                No sales or invoices recorded yet.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

</div>

</body>
</html>
