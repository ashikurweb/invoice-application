<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .receipt {
            max-width: 350px;
            background: white;
            padding: 10px;
            margin: 20px auto;
            border: 1px solid #ccc;
        }
        .header h1 {
            font-size: 16px;
            margin: 5px 0;
            text-align: center;
        }
        .details, .footer {
            border-top: 1px dashed black;
            padding: 5px 0;
            text-align: left;
        }
        /* Item Container */
        .item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }
        .item:last-child {
            border-bottom: none;
        }
        /* Item Details Flexbox */
        .item-details {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            gap: 5px;
        }
        .item-details span {
            flex: 1;
            text-align: center;
            font-size: 10px;
        }
        .item-code {
            text-align: left;
        }
        .unit-price, .quantity, .total {
            text-align: right;
        }
        .footer {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>Payment Receipt</h1>
        </div>

        <div class="details">
            <p><strong>Receipt To:</strong> {{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}</p>
            <p><strong>Receipt Number:</strong> {{ $invoice->number }}</p>
            <p><strong>Date:</strong> {{ $invoice->date }}</p>
            <p><strong>Payment Date:</strong> {{ $invoice->created_at_formatted }}</p>
        </div>

        <!-- Item Header -->
        <div class="item">
            <div class="item-details">
                <span class="item-code"><strong>Item Code</strong></span>
                <span class="unit-price"><strong>Unit Price</strong></span>
                <span class="quantity"><strong>Qty</strong></span>
                <span class="total"><strong>Total</strong></span>
            </div>
        </div>

        <!-- Loop through invoice items -->
        @foreach ($invoice->invoice_items as $item)
            <div class="item">
                <div class="item-details">
                    <span class="item-code">{{ $item->product->item_code }}</span>
                    <span class="unit-price">${{ number_format($item->unit_price, 2) }}</span>
                    <span class="quantity">{{ $item->quantity }}</span>
                    <span class="total">${{ number_format($item->unit_price * $item->quantity, 2) }}</span>
                </div>
            </div>
        @endforeach

        <div class="footer">
            <p><strong>Sub Total:</strong> ${{ number_format($invoice->sub_total, 2) }}</p>
            <p><strong>Discount:</strong> ${{ number_format($invoice->discount, 2) }}</p>
            <p><strong>Grand Total:</strong> ${{ number_format($invoice->total, 2) }}</p>
        </div>
        
    </div>
</body>
</html>
