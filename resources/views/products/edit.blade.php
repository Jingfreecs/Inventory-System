<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Product - Inventory System</title>

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
            <h4 class="mb-0">Edit Product</h4>
        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('products.update', $product) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <select name="category_id"
                            class="form-select"
                            required>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Product Code
                    </label>

                    <input type="text"
                           name="product_code"
                           class="form-control"
                           value="{{ old('product_code', $product->product_code) }}"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Product Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $product->name) }}"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description', $product->description) }}</textarea>

                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Price
                        </label>

                        <input type="number"
                               name="price"
                               class="form-control"
                               value="{{ old('price', $product->price) }}"
                               step="0.01"
                               min="0"
                               required>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Quantity
                        </label>

                        <input type="number"
                               name="quantity"
                               class="form-control"
                               value="{{ old('quantity', $product->quantity) }}"
                               min="0"
                               required>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Reorder Level
                        </label>

                        <input type="number"
                               name="reorder_level"
                               class="form-control"
                               value="{{ old('reorder_level', $product->reorder_level) }}"
                               min="0"
                               required>

                    </div>

                </div>

                <button type="submit"
                        class="btn btn-success">
                    Update Product
                </button>

                <a href="{{ route('products.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>
