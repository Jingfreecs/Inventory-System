<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Details - Inventory System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            📦 Inventory System
        </a>

    </div>
</nav>

<div class="container mt-4">

    <div class="card">

        <div class="card-header">
            <h4 class="mb-0">Product Details</h4>
        </div>

        <div class="card-body">

            <h3>{{ $product->name }}</h3>

            <hr>

            <p>
                <strong>Product Code:</strong>
                {{ $product->product_code }}
            </p>

            <p>
                <strong>Category:</strong>
                {{ $product->category->name }}
            </p>

            <p>
                <strong>Description:</strong>
                {{ $product->description ?? 'No description' }}
            </p>

            <p>
                <strong>Price:</strong>
                ₱{{ number_format($product->price, 2) }}
            </p>

            <p>
                <strong>Current Quantity:</strong>
                {{ $product->quantity }}
            </p>

            <p>
                <strong>Reorder Level:</strong>
                {{ $product->reorder_level }}
            </p>

            <a href="{{ route('products.edit', $product) }}"
               class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('products.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </div>

    </div>

</div>

</body>
</html>
