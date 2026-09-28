<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Stock History - Inventory System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
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

        </div>

    </div>

</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>Stock Movement History</h2>

        <a href="{{ route('stock-in.create') }}"
        class="btn btn-success">
        + Stock IN
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if($movements->count() > 0)

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

                    @foreach($movements as $movement)

                        <tr>

                            <td>
                                {{ $movement->id }}
                            </td>

                            <td>
                                {{ $movement->created_at->format('M d, Y h:i A') }}
                            </td>

                            <td>

                                {{ $movement->product->name }}

                                <br>

                                <small class="text-muted">
                                    {{ $movement->product->product_code }}
                                </small>

                            </td>

                            <td>

                                @if($movement->type === 'IN')

                                    <span class="badge bg-success">
                                        STOCK IN
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        STOCK OUT
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $movement->quantity }}
                            </td>

                            <td>
                                {{ $movement->remarks ?? '—' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="alert alert-info">

            No stock movements have been recorded yet.

        </div>

    @endif

</div>

</body>

</html>
