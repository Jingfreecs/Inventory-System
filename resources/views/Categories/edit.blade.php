<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Category - Inventory System</title>

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
            <h4 class="mb-0">Edit Category</h4>
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

            <form action="{{ route('categories.update', $category) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Category Name</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $category->name) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>

                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $category->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    Update Category
                </button>

                <a href="{{ route('categories.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>
