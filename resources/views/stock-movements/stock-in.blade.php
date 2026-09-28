<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Stock IN - Inventory System</title>

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

            <a href="{{ route('products.index') }}"
               class="btn btn-outline-light btn-sm">

                Products

            </a>

            <a href="{{ route('stock-movements.index') }}"
               class="btn btn-outline-light btn-sm">

                Movements

            </a>

        </div>

    </div>

</nav>


<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card">

                <div class="card-header bg-success text-white">

                    <h4 class="mb-0">
                        📥 Stock IN
                    </h4>

                </div>


                <div class="card-body">

                    <form method="POST"
                          action="{{ route('stock-in.store') }}">

                        @csrf


                        {{-- PRODUCT --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Product
                            </label>

                            <select name="product_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Select Product
                                </option>

                                @foreach($products as $product)

                                    <option value="{{ $product->id }}">

                                        {{ $product->product_code }}
                                        -
                                        {{ $product->name }}
                                        (Current Stock:
                                        {{ $product->quantity }})

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- QUANTITY --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Quantity
                            </label>

                            <input type="number"
                                   name="quantity"
                                   class="form-control"
                                   min="1"
                                   required>

                        </div>


                        {{-- REMARKS --}}

                        <div class="mb-3">

                            <label class="form-label">
                                Remarks
                            </label>

                            <textarea name="remarks"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Optional remarks..."></textarea>

                        </div>


                        <div class="d-flex justify-content-between">

                            <a href="{{ route('products.index') }}"
                               class="btn btn-secondary">

                                Cancel

                            </a>

                            <button type="submit"
                                    class="btn btn-success">

                                Record Stock IN

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
