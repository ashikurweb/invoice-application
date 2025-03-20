<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all_products()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return response()->json([
            'products' => $products
        ], 200);
    }

    public function add_invoice(Request $request)
    {
        $invoice_item = $request->input('invoice_item');
        $invoiceData['sub_total'] = $request->input('subtotal');
        $invoiceData['total'] = $request->input('total');
        $invoiceData['customer_id'] = $request->input('customer_id');
        $invoiceData['date'] = $request->input('date');
        $invoiceData['due_date'] = $request->input('due_date');
        $invoiceData['discount'] = $request->input('discount');
        $invoiceData['reference'] = $request->input('reference');
        $invoiceData['terms_and_conditions'] = $request->input('terms_and_conditions');


        $invoice = Invoice::create($invoiceData);

        foreach(json_decode($invoice_item) as $item) {
            $itemData['product_id'] = $item->id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity'] = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;
        }


        InvoiceItem::create( $itemData );
    }
}
