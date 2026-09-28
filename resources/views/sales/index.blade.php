<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Sales History - Inventory System</title>

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

            <a href="{{ route('sales.create') }}"
               class="btn btn-success btn-sm">

                + New Sale

            </a>

        </div>

    </div>

</nav>


<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>Sales History</h2>

        <a href="{{ route('sales.create') }}"
           class="btn btn-primary">

            + New Sale

        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    @if($sales->count() > 0)

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>Invoice</th>

                        <th>Date</th>

                        <th>Items</th>

                        <th>Total</th>

                        <th>Cash</th>

                        <th>Change</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($sales as $sale)

                        <tr>

                            <td>
                                {{ $sale->invoice_number }}
                            </td>

                            <td>
                                {{ $sale->created_at->format('M d, Y h:i A') }}
                            </td>

                            <td>

                                {{ $sale->items->sum('quantity') }}

                            </td>

                            <td>

                                <strong>
                                    ₱{{ number_format($sale->total_amount, 2) }}
                                </strong>

                            </td>

                            <td>
                                ₱{{ number_format($sale->cash_received, 2) }}
                            </td>

                            <td>
                                ₱{{ number_format($sale->change_amount, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="alert alert-info">

            No sales recorded yet.

        </div>

    @endif

</div>

</body>

</html>
