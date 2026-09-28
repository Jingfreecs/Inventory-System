<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categories - Inventory System</title>

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
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                Dashboard
            </a>

            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">
                Products
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Categories</h2>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($categories->count() > 0)

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th width="250">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($categories as $category)

                        <tr>
                            <td>{{ $category->id }}</td>

                            <td>
                                {{ $category->name }}
                            </td>

                            <td>
                                {{ $category->description ?? 'No description' }}
                            </td>

                            <td>

                                <a href="{{ route('categories.show', $category) }}"
                                   class="btn btn-info btn-sm">
                                    View
                                </a>

                                <a href="{{ route('categories.edit', $category) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('categories.destroy', $category) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                        Delete
                                    </button>

                                </form>

                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="alert alert-info">
            No categories found. Click <strong>Add Category</strong> to create one.
        </div>

    @endif

</div>

</body>
</html>
