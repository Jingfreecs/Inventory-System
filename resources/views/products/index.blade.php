<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Products - Inventory System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            📦 Inventory System
        </a>

        <div>

            <a href="{{ route('dashboard') }}"
               class="btn btn-outline-light btn-sm">
                Dashboard
            </a>

            <a href="{{ route('categories.index') }}"
               class="btn btn-outline-light btn-sm">
                Categories
            </a>

            <a href="{{ route('stock-in.create') }}"
               class="btn btn-success btn-sm">
                + Stock IN
            </a>

            <a href="{{ route('stock-movements.index') }}"
               class="btn btn-outline-light btn-sm">
                Movements
            </a>

        </div>

    </div>

</nav>


<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>Products</h2>

        <a href="{{ route('products.create') }}"
           class="btn btn-primary">
            + Add Product
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- SEARCH AND FILTER --}}

    <div class="card mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('products.index') }}">

                <div class="row g-3">

                    <div class="col-md-5">

                        <label class="form-label">
                            Search
                        </label>

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Product code or name..."
                               value="{{ request('search') }}">

                    </div>


                    <div class="col-md-3">

                        <label class="form-label">
                            Category
                        </label>

                        <select name="category_id"
                                class="form-select">

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-2">

                        <label class="form-label">
                            Stock
                        </label>

                        <select name="stock_status"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="low"
                                {{ request('stock_status') === 'low' ? 'selected' : '' }}>

                                Low Stock

                            </option>

                        </select>

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary me-2">

                            Search

                        </button>

                        <a href="{{ route('products.index') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- STOCK OUT FORM --}}

    <form method="POST"
          action="{{ route('stock-out.store') }}">

        @csrf


        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0">
                Products
            </h5>

            <button type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to record the selected products as Stock OUT?')">

                Stock OUT Selected

            </button>

        </div>


        @if($products->count() > 0)

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th width="60">
                                OUT
                            </th>

                            <th>#</th>

                            <th>Code</th>

                            <th>Product</th>

                            <th>Category</th>

                            <th>Price</th>

                            <th>Current Stock</th>

                            <th>OUT Quantity</th>

                            <th>Reorder Level</th>

                            <th width="150">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($products as $product)

                            <tr>

                                {{-- CHECKBOX --}}

                                <td class="text-center">

                                    @if($product->quantity > 0)

                                        <input type="checkbox"
                                               name="products[]"
                                               value="{{ $product->id }}"
                                               class="form-check-input"
                                               style="transform: scale(1.3);">

                                    @else

                                        <span class="badge bg-secondary">
                                            Empty
                                        </span>

                                    @endif

                                </td>


                                <td>
                                    {{ $product->id }}
                                </td>


                                <td>
                                    {{ $product->product_code }}
                                </td>


                                <td>
                                    {{ $product->name }}
                                </td>


                                <td>
                                    {{ $product->category->name }}
                                </td>


                                <td>
                                    ₱{{ number_format($product->price, 2) }}
                                </td>


                                {{-- CURRENT STOCK --}}

                                <td>

                                    @if($product->quantity <= $product->reorder_level)

                                        <span class="badge bg-danger">
                                            {{ $product->quantity }}
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            {{ $product->quantity }}
                                        </span>

                                    @endif

                                </td>


                                {{-- OUT QUANTITY --}}

                                <td style="width: 120px;">

                                    @if($product->quantity > 0)

                                        <input type="number"
                                               name="quantities[{{ $product->id }}]"
                                               class="form-control form-control-sm"
                                               value="1"
                                               min="1"
                                               max="{{ $product->quantity }}">

                                    @else

                                        <input type="number"
                                               class="form-control form-control-sm"
                                               value="0"
                                               disabled>

                                    @endif

                                </td>


                                <td>
                                    {{ $product->reorder_level }}
                                </td>


                                <td>

                                    <a href="{{ route('products.show', $product) }}"
                                       class="btn btn-info btn-sm">

                                        View

                                    </a>

                                    <a href="{{ route('products.edit', $product) }}"
                                       class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="alert alert-info">

                No products found.

            </div>

        @endif

    </form>

</div>

</body>

</html>
