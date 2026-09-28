<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Product - Inventory System</title>

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
            <h4 class="mb-0">Add Product</h4>
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

            @if($categories->count() == 0)

                <div class="alert alert-warning">
                    Please create a category first before adding a product.
                </div>

                <a href="{{ route('categories.create') }}"
                   class="btn btn-primary">
                    Create Category
                </a>

            @else

                <form action="{{ route('products.store') }}"
                      method="POST">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label">
                            Category
                        </label>

                        <select name="category_id"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select Category --
                            </option>

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>

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
                               value="{{ old('product_code') }}"
                               placeholder="Example: LAP-001"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Product Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               placeholder="Enter product name"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="3">{{ old('description') }}</textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Price
                            </label>

                            <input type="number"
                                   name="price"
                                   class="form-control"
                                   value="{{ old('price') }}"
                                   step="0.01"
                                   min="0"
                                   required>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Initial Quantity
                            </label>

                            <input type="number"
                                   name="quantity"
                                   class="form-control"
                                   value="{{ old('quantity', 0) }}"
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
                                   value="{{ old('reorder_level', 10) }}"
                                   min="0"
                                   required>

                        </div>

                    </div>

                    <button type="submit"
                            class="btn btn-primary">
                        Save Product
                    </button>

                    <a href="{{ route('products.index') }}"
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
