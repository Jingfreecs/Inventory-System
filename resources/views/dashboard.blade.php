<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventory System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            Manding Store - Inventory System
        </a>

        <div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light">
                Products
            </a>

            <a href="{{ route('categories.index') }}" class="btn btn-outline-light">
                Categories
            </a>

            <a href="{{ route('stock-movements.index') }}" class="btn btn-outline-light">
                Stock History
            </a>

            <a href="{{ route('reports.index') }}"
                class="btn btn-outline-light ">
                Reports
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <h2>Dashboard</h2>
    <p class="text-muted">Inventory overview</p>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5>Total Products</h5>
                    <h2>{{ $totalProducts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5>Total Categories</h5>
                    <h2>{{ $totalCategories }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-bg-info">
                <div class="card-body">
                    <h5>Total Stock</h5>
                    <h2>{{ $totalStock }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-bg-danger">
                <div class="card-body">
                    <h5>Low Stock</h5>
                    <h2>{{ $lowStock }}</h2>

                    <a href="{{ route('low-stock.index') }}" class="btn btn-warning">
                        View
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">

    <div class="card shadow-sm">

        <div class="card-body">

            <h6 class="text-muted">
                Today's Sales
            </h6>

            <h3 class="text-success">

                ₱{{ number_format($todaySales, 2) }}

            </h3>

            <p class="mb-0">

                {{ $todayTransactions }} transaction(s)

            </p>

        </div>

    </div>

</div>

    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h4>Welcome!</h4>
            <p>
                Use the navigation buttons above to manage your products
                and categories.
            </p>

            <a href="{{ route('products.create') }}" class="btn btn-primary">
                + Add Product
            </a>

            <a href="{{ route('categories.create') }}" class="btn btn-secondary">
                + Add Category
            </a>

            <a href="{{ route('sales.create') }}"
                class="btn btn-success">
                🛒 New Sale
            </a>

            <a href="{{ route('sales.index') }}"
                class="btn btn-outline-primary">
                Sales History
            </a>
        </div>
    </div>

</div>

</body>
</html>
