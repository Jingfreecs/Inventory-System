<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice {{ $sale->invoice_number }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Invoice Details
        </h2>

        <div>
            <a href="{{ route('sales.invoice', $sale) }}"
               class="btn btn-success">
                🖨 Print Invoice
            </a>

            <a href="{{ route('reports.index') }}"
               class="btn btn-secondary">
                Back to Reports
            </a>
        </div>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">

                    <h4>📦 Inventory System</h4>

                    <p class="mb-1">
                        <strong>Invoice:</strong>
                        {{ $sale->invoice_number }}
                    </p>

                    <p class="mb-1">
                        <strong>Date:</strong>
                        {{ $sale->created_at->format('M d, Y h:i A') }}
                    </p>

                </div>

                <div class="col-md-6 text-md-end">

                    <p class="mb-1">
                        <strong>Status:</strong>
                        <span class="badge bg-success">
                            PAID
                        </span>
                    </p>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="table-light">

                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($sale->items as $item)

                            <tr>

                                <td>
                                    {{ $item->product->name }}
                                </td>

                                <td>
                                    ₱{{ number_format($item->price, 2) }}
                                </td>

                                <td>
                                    {{ $item->quantity }}
                                </td>

                                <td>
                                    ₱{{ number_format($item->subtotal, 2) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="row justify-content-end">

                <div class="col-md-5">

                    <table class="table">

                        <tr>
                            <th>Total:</th>
                            <td class="text-end">
                                <strong>
                                    ₱{{ number_format($sale->total_amount, 2) }}
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Cash Received:</th>
                            <td class="text-end">
                                ₱{{ number_format($sale->cash_received, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Change:</th>
                            <td class="text-end">
                                ₱{{ number_format($sale->change_amount, 2) }}
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
