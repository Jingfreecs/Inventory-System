<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Stock Movement - Inventory System</title>

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

    </div>

</nav>

<div class="container mt-4">

    <div class="card">

        <div class="card-header">

            <h4 class="mb-0">
                Stock In / Stock Out
            </h4>

        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

            @if($products->count() == 0)

                <div class="alert alert-warning">

                    No products are available.

                    Please create a product first.

                </div>

                <a href="{{ route('products.create') }}"
                   class="btn btn-primary">

                    Create Product

                </a>

            @else

                <form action="{{ route('stock-movements.store') }}"
                      method="POST">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label">
                            Product
                        </label>

                        <select name="product_id"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Product --
                            </option>

                            @foreach($products as $product)

                                <option value="{{ $product->id }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>

                                    {{ $product->product_code }}
                                    -
                                    {{ $product->name }}
                                    (Stock: {{ $product->quantity }})

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Transaction Type
                        </label>

                        <select name="type"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Type --
                            </option>

                            <option value="IN"
                                {{ old('type') === 'IN' ? 'selected' : '' }}>

                                STOCK IN

                            </option>

                            <option value="OUT"
                                {{ old('type') === 'OUT' ? 'selected' : '' }}>

                                STOCK OUT

                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Quantity
                        </label>

                        <input type="number"
                               name="quantity"
                               class="form-control"
                               value="{{ old('quantity') }}"
                               min="1"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea name="remarks"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Optional remarks">{{ old('remarks') }}</textarea>

                    </div>

                    <button type="submit"
                            class="btn btn-primary">

                        Record Movement

                    </button>

                    <a href="{{ route('stock-movements.index') }}"
                       class="btn btn-secondary">

                        Cancel

                    </a>

                </form>

            @endif

        </div>

    </div>

</div>

</body>

</html>
