<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Low Stock Products - Inventory System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            📦 Inventory System
        </a>

        <div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">
                Products
            </a>

            <a href="{{ route('categories.index') }}" class="btn btn-outline-light btn-sm">
                Categories
            </a>

            <a href="{{ route('stock-movements.index') }}" class="btn btn-outline-light btn-sm">
                Stock Movements
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>⚠️ Low Stock Products</h2>
            <p class="text-muted">
                Products that have reached or fallen below their reorder level.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>
    </div>

    @if($products->count() > 0)

        <div class="alert alert-warning">
            There are <strong>{{ $products->count() }}</strong>
            product(s) that need attention.
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Reorder Level</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($products as $product)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $product->product_code }}
                            </td>

                            <td>
                                <strong>{{ $product->name }}</strong>
                            </td>

                            <td>
                                {{ $product->category->name ?? 'No Category' }}
                            </td>

                            <td>
                                <span class="badge bg-danger fs-6">
                                    {{ $product->quantity }}
                                </span>
                            </td>

                            <td>
                                {{ $product->reorder_level }}
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    Low Stock
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('products.show', $product) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('stock-movements.create') }}"
                                    class="btn btn-success btn-sm"
                                >
                                    Add Stock
                                </a>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>
        </div>

    @else

        <div class="alert alert-success">
            <h5>✅ All Stock Levels Are Good</h5>

            <p class="mb-0">
                There are currently no products that have reached their reorder level.
            </p>
        </div>

    @endif

</div>

</body>
</html>
