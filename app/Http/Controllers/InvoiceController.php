<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_all_invoice()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
        return response()->json([
            'invoices'  => $invoices
        ], 200);
    }


    public function search_invoice(Request $request)
    {
        $search = $request->get('s');
        if ($search) {
            $invoices = Invoice::with('customer')
            ->whereHas('customer', function($query) use ($search) {
                $query->where('first_name', 'like', "%$search%");
            })
            ->get();

            return response()->json([
                'invoices'  => $invoices
            ], 200);
        } else {
            return $this->get_all_invoice();
        }
    }

    public function create_invoice(Request $request)
    {
        $counter = Counter::where('key', 'invoice')->first();
        $random  = Counter::where('key', 'invoice')->first();
        $counter = Counter::firstOrCreate(
            ['key' => 'invoice'],
            ['prefix' => 'INV-', 'value' => 1000] 
        );

        $invoice = Invoice::orderBy('id', 'DESC')->first();
        if ( $invoice ) {
            $invoice  = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value;
        }


        $formData = [
            'number'        => $counter->prefix . $counters,
            'customer_id'   => null,
            'customber'     => null,
            'date'          => date('Y-m-d'),
            'due_date'      => null,
            'reference'     => null,
            'discount'      => 0,
            'terms_and_conditions' => 'Default Terms and Conditions',

            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1
                ]
            ]
        ];

        return response()->json($formData);
    }


    public function add_invoice(Request $request)
    {
        $invoice_item = $request->input('invoice_item');

        $invoiceData['sub_total']   = $request->input('subtotal');
        $invoiceData['total']       = $request->input('total');
        $invoiceData['customer_id'] = $request->input('customer_id');
        $invoiceData['date']        = $request->input('date');
        $invoiceData['number']      = $request->input('number');
        $invoiceData['due_date']    = $request->input('due_date');
        $invoiceData['discount']    = $request->input('discount');
        $invoiceData['reference']   = $request->input('reference');
        $invoiceData['terms_and_conditions'] = $request->input('terms_and_conditions');


        $invoice = Invoice::create($invoiceData);

        foreach(json_decode($invoice_item) as $item) {
            $itemData['product_id'] = $item->id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity']   = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;
        }


        InvoiceItem::create( $itemData );
    }


    public function show_invoice ( $id )
    {
        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);

        return response()->json([
            'invoice' => $invoice
        ], 200);
    }


    public function edit_invoice ( $id )
    {
        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);
        return response()->json([
            'invoice' => $invoice
        ], 200);
    }

    public function destroy_invoice_item ( $id )

    {
        $invoiceItem = InvoiceItem::findOrFail($id);
        $invoiceItem->delete();
    }

    public function update_invoice ( Request $request, $id )
    {
        $invoice = Invoice::where('id', $id)->first();

        $invoice->sub_total   = $request->subtotal;
        $invoice->total       = $request->total;
        $invoice->customer_id = $request->customer_id;
        $invoice->number      = $request->number;
        $invoice->date        = $request->date;
        $invoice->due_date    = $request->due_date;
        $invoice->discount    = $request->discount;
        $invoice->reference   = $request->reference;
        $invoice->terms_and_conditions = $request->terms_and_conditions;

        
        $invoice->update($request->all());
        
        $invoice_item = $request->input('invoice_item');
        $invoice->invoice_items()->delete(); 
        

        foreach(json_decode($invoice_item) as $item) {
            $itemData['product_id'] = $item->product_id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity']   = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;
        }
    }

    public function destroy_invoice ( $id )
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->invoice_items()->delete();
        $invoice->delete();
    }
}
