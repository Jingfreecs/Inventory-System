<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Category Details - Inventory System</title>

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
            <h4 class="mb-0">Category Details</h4>
        </div>

        <div class="card-body">

            <h5>{{ $category->name }}</h5>

            <p>
                <strong>Description:</strong>
                {{ $category->description ?? 'No description' }}
            </p>

            <p>
                <strong>Created:</strong>
                {{ $category->created_at->format('M d, Y h:i A') }}
            </p>

            <a href="{{ route('categories.edit', $category) }}"
               class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('categories.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </div>

    </div>

</div>

</body>
</html>
