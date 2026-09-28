<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Invoice {{ $sale->invoice_number }}
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
        }

        .invoice {
            max-width: 700px;
            margin: auto;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
        }

        .print-button {
            margin-bottom: 20px;
            padding: 10px 18px;
            border: none;
            background: #198754;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        @media print {

            .print-button {
                display: none;
            }

            body {
                padding: 0;
            }

        }

    </style>

</head>

<body>

<div class="invoice">

    <button
        class="print-button"
        onclick="window.print()">
        🖨 Print Invoice
    </button>


    <div class="text-center">

        <h2>📦 INVENTORY SYSTEM</h2>

        <p>Official Sales Invoice</p>

        <hr>

    </div>


    <p>
        <strong>Invoice Number:</strong>
        {{ $sale->invoice_number }}
    </p>

    <p>
        <strong>Date:</strong>
        {{ $sale->created_at->format('M d, Y h:i A') }}
    </p>


    <table>

        <thead>

            <tr>

                <th>Product</th>

                <th>Qty</th>

                <th>Price</th>

                <th class="text-right">
                    Amount
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($sale->items as $item)

                <tr>

                    <td>
                        {{ $item->product->name }}
                    </td>

                    <td>
                        {{ $item->quantity }}
                    </td>

                    <td>
                        ₱{{ number_format($item->price, 2) }}
                    </td>

                    <td class="text-right">
                        ₱{{ number_format($item->subtotal, 2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    <table>

        <tr>

            <td>
                <strong>TOTAL</strong>
            </td>

            <td class="text-right total">
                ₱{{ number_format($sale->total_amount, 2) }}
            </td>

        </tr>

        <tr>

            <td>
                Cash Received
            </td>

            <td class="text-right">
                ₱{{ number_format($sale->cash_received, 2) }}
            </td>

        </tr>

        <tr>

            <td>
                Change
            </td>

            <td class="text-right">
                ₱{{ number_format($sale->change_amount, 2) }}
            </td>

        </tr>

    </table>


    <div class="text-center">

        <br>

        <p>
            <strong>Thank you for your purchase!</strong>
        </p>

    </div>

</div>

</body>

</html>
