<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice { max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin: 0; }
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .table th { background-color: #f9f9f9; }
        .footer { text-align: right; }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <h1>Invoice</h1>
        </div>
        <div class="details">
            <p><strong>Invoice To:</strong> {{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}</p>
            <p><strong>Invoice Number:</strong> {{ $invoice->number }}</p>
            <p><strong>Date:</strong> {{ $invoice->date }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
            <p><strong>Reference:</strong> {{ $invoice->reference }}</p>
            <!-- Add Created At with Timezone -->
            <p><strong>Created At:</strong> {{ $invoice->created_at_formatted }}</p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Description</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->invoice_items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->description }}</td>
                        <td>${{ $item->unit_price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->unit_price * $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer">
            <p><strong>Sub Total:</strong> ${{ $invoice->sub_total }}</p>
            <p><strong>Discount:</strong> ${{ $invoice->discount }}</p>
            <p><strong>Grand Total:</strong> ${{ $invoice->total }}</p>
        </div>
    </div>
</body>
</html>