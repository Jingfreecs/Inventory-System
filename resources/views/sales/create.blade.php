<!DOCTYPE html>

<html lang="en">

<head>

```
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>New Sale - Inventory System</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>
```

</head>

<body>

{{-- ========================================== --}}
{{-- NAVBAR --}}
{{-- ========================================== --}}

<nav class="navbar navbar-dark bg-dark">

```
<div class="container">

    <a
        class="navbar-brand"
        href="{{ route('dashboard') }}"
    >
        📦 Inventory System
    </a>


    <div>

        <a
            href="{{ route('dashboard') }}"
            class="btn btn-outline-light btn-sm"
        >
            Dashboard
        </a>


        <a
            href="{{ route('products.index') }}"
            class="btn btn-outline-light btn-sm"
        >
            Products
        </a>


        <a
            href="{{ route('sales.index') }}"
            class="btn btn-outline-light btn-sm"
        >
            Sales History
        </a>

    </div>

</div>
```

</nav>

{{-- ========================================== --}}
{{-- MAIN CONTAINER --}}
{{-- ========================================== --}}

<div class="container mt-4">

```
{{-- PAGE TITLE --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        🛒 New Sale
    </h2>

</div>



{{-- ========================================== --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================== --}}

@if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif



{{-- ========================================== --}}
{{-- ERROR MESSAGE --}}
{{-- ========================================== --}}

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



{{-- ========================================== --}}
{{-- MAIN ROW --}}
{{-- ========================================== --}}

<div class="row g-4">



    {{-- ====================================== --}}
    {{-- PRODUCT SEARCH / SELECTION --}}
    {{-- ====================================== --}}

    <div class="col-md-7">


        <div class="card shadow-sm mb-4">


            {{-- CARD HEADER --}}

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">

                    🛒 Add Products

                </h5>

            </div>



            {{-- CARD BODY --}}

            <div class="card-body">



                {{-- ================================== --}}
                {{-- SEARCH BAR --}}
                {{-- ================================== --}}

                <div class="mb-4">

                    <label
                        class="form-label fw-bold"
                        for="productSearch"
                    >

                        🔍 Search Product

                    </label>


                    <input
                        type="text"
                        id="productSearch"
                        class="form-control form-control-lg"
                        placeholder="Search by product code or product name..."
                        autocomplete="off"
                    >

                </div>



                {{-- ================================== --}}
                {{-- PRODUCT COUNT --}}
                {{-- ================================== --}}

                <div class="d-flex justify-content-between mb-3">

                    <span class="text-muted">

                        Available Products

                    </span>


                    <span
                        id="productCount"
                        class="badge bg-secondary"
                    >

                        {{ $products->count() }} product(s)

                    </span>

                </div>



                {{-- ================================== --}}
                {{-- PRODUCT CARDS --}}
                {{-- ================================== --}}

                <div
                    class="row g-3"
                    id="productList"
                >


                    @foreach($products as $product)


                        <div
                            class="col-md-6 product-card"
                            data-search="{{ strtolower($product->product_code . ' ' . $product->name) }}"
                        >


                            <div class="card h-100 border shadow-sm">


                                <div class="card-body">



                                    {{-- PRODUCT NAME --}}

                                    <h5 class="card-title">

                                        {{ $product->name }}

                                    </h5>



                                    {{-- PRODUCT CODE --}}

                                    <p class="text-muted mb-1">

                                        Code:

                                        <strong>

                                            {{ $product->product_code }}

                                        </strong>

                                    </p>



                                    {{-- PRODUCT PRICE --}}

                                    <h5 class="text-success mb-2">

                                        ₱{{ number_format($product->price, 2) }}

                                    </h5>



                                    {{-- PRODUCT STOCK --}}

                                    <p class="mb-3">


                                        @if($product->quantity > $product->reorder_level)


                                            <span class="badge bg-success">

                                                Stock:
                                                {{ $product->quantity }}

                                            </span>


                                        @elseif($product->quantity > 0)


                                            <span class="badge bg-warning text-dark">

                                                Low Stock:
                                                {{ $product->quantity }}

                                            </span>


                                        @else


                                            <span class="badge bg-danger">

                                                Out of Stock

                                            </span>


                                        @endif


                                    </p>



                                    {{-- ================================== --}}
                                    {{-- ADD TO CART FORM --}}
                                    {{-- ================================== --}}

                                    @if($product->quantity > 0)


                                        <form
                                            method="POST"
                                            action="{{ route('sales.cart.add') }}"
                                        >

                                            @csrf


                                            <input
                                                type="hidden"
                                                name="product_id"
                                                value="{{ $product->id }}"
                                            >


                                            <div class="input-group">


                                                <input
                                                    type="number"
                                                    name="quantity"
                                                    value="1"
                                                    min="1"
                                                    max="{{ $product->quantity }}"
                                                    class="form-control"
                                                    required
                                                >


                                                <button
                                                    type="submit"
                                                    class="btn btn-primary"
                                                >

                                                    + Add

                                                </button>


                                            </div>


                                        </form>


                                    @else


                                        <button
                                            type="button"
                                            class="btn btn-secondary w-100"
                                            disabled
                                        >

                                            Out of Stock

                                        </button>


                                    @endif


                                </div>

                            </div>


                        </div>


                    @endforeach



                    {{-- ================================== --}}
                    {{-- NO PRODUCTS FOUND --}}
                    {{-- ================================== --}}

                    <div
                        id="noProducts"
                        class="col-12 text-center py-5"
                        style="display: none;"
                    >

                        <h5 class="text-muted">

                            🔍 No products found

                        </h5>


                        <p class="text-muted mb-0">

                            Try searching using a different
                            product name or code.

                        </p>

                    </div>


                </div>


            </div>

        </div>


    </div>



    {{-- ====================================== --}}
    {{-- SHOPPING CART --}}
    {{-- ====================================== --}}

    <div class="col-md-5">


        <div class="card shadow-sm">


            {{-- CART HEADER --}}

            <div class="card-header d-flex justify-content-between align-items-center">

                <strong>

                    🛒 Shopping Cart

                </strong>



                @if(count($cartProducts) > 0)


                    <form
                        method="POST"
                        action="{{ route('sales.cart.clear') }}"
                    >

                        @csrf

                        @method('DELETE')


                        <button
                            type="submit"
                            class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Clear the entire cart?')"
                        >

                            Clear Cart

                        </button>


                    </form>


                @endif


            </div>



            {{-- CART BODY --}}

            <div class="card-body">


                @if(count($cartProducts) > 0)



                    {{-- ================================== --}}
                    {{-- CART TABLE --}}
                    {{-- ================================== --}}

                    <div class="table-responsive">


                        <table class="table table-bordered align-middle">


                            <thead class="table-light">


                                <tr>


                                    <th>
                                        Product
                                    </th>


                                    <th>
                                        Price
                                    </th>


                                    <th>
                                        Qty
                                    </th>


                                    <th>
                                        Subtotal
                                    </th>


                                    <th>
                                    </th>


                                </tr>


                            </thead>



                            <tbody>


                                @foreach($cartProducts as $item)


                                    <tr>


                                        {{-- PRODUCT --}}

                                        <td>

                                            <strong>

                                                {{ $item['product']->name }}

                                            </strong>


                                            <br>


                                            <small class="text-muted">

                                                {{ $item['product']->product_code }}

                                            </small>

                                        </td>



                                        {{-- PRICE --}}

                                        <td>

                                            ₱{{ number_format($item['product']->price, 2) }}

                                        </td>



                                        {{-- QUANTITY --}}

                                        <td>

                                            {{ $item['quantity'] }}

                                        </td>



                                        {{-- SUBTOTAL --}}

                                        <td>

                                            ₱{{ number_format($item['subtotal'], 2) }}

                                        </td>



                                        {{-- REMOVE --}}

                                        <td>


                                            <form
                                                method="POST"
                                                action="{{ route('sales.cart.remove', $item['product']->id) }}"
                                            >

                                                @csrf

                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Remove this product from the cart?')"
                                                >

                                                    Remove

                                                </button>


                                            </form>


                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>


                    </div>



                    {{-- ================================== --}}
                    {{-- TOTAL --}}
                    {{-- ================================== --}}

                    <div class="text-end mt-3">


                        <span class="text-muted">

                            Total Amount

                        </span>


                        <h3 class="text-success">

                            ₱{{ number_format($total, 2) }}

                        </h3>


                    </div>



                    <hr>



                    {{-- ================================== --}}
                    {{-- CHECKOUT --}}
                    {{-- ================================== --}}

                    <form
                        method="POST"
                        action="{{ route('sales.checkout') }}"
                    >

                        @csrf



                        {{-- CASH RECEIVED --}}

                        <div class="mb-3">


                            <label
                                class="form-label fw-bold"
                                for="cash_received"
                            >

                                Cash Received

                            </label>


                            <input
                                type="number"
                                name="cash_received"
                                id="cash_received"
                                class="form-control form-control-lg"
                                min="{{ $total }}"
                                step="0.01"
                                placeholder="₱0.00"
                                required
                            >


                        </div>



                        {{-- COMPLETE SALE BUTTON --}}

                        <button
                            type="submit"
                            class="btn btn-success btn-lg w-100"
                            onclick="return confirm('Complete this sale?')"
                        >

                             Complete Sale

                        </button>


                    </form>



                @else



                    {{-- ================================== --}}
                    {{-- EMPTY CART --}}
                    {{-- ================================== --}}

                    <div class="text-center text-muted py-5">


                        <div
                            style="font-size: 50px;"
                        >


                        </div>


                        <h5>

                            Your cart is empty

                        </h5>


                        <p class="mb-0">

                            Search for a product and click
                            <strong>+ Add</strong> to start a sale.

                        </p>


                    </div>



                @endif


            </div>


        </div>


    </div>


</div>
```

</div>



<script>
    const searchInput = document.getElementById('productSearch');
    const productCards = document.querySelectorAll('.product-card');
    const productCount = document.getElementById('productCount');
    const noProducts = document.getElementById('noProducts');

    searchInput.addEventListener('input', function () {

        const search = this.value.toLowerCase().trim();

        let visibleCount = 0;

        productCards.forEach(function (card) {

            const productText =
                card.getAttribute('data-search') || '';

            if (productText.includes(search)) {

                card.style.display = '';

                visibleCount++;

            } else {

                card.style.display = 'none';

            }

        });

        productCount.textContent =
            visibleCount + ' product(s)';

        if (visibleCount === 0) {

            noProducts.style.display = '';

        } else {

            noProducts.style.display = 'none';

        }

    });
</script>

</body>

</html>
