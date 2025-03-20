<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_all_invoice()
    {
        // $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->paginate(8);
        // return response()->json($invoices, 200);

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


}
