<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/invoice/pdf/{id}', [InvoiceController::class, 'downloadPdf']);
Route::get('/invoices/{id}/download-receipt', [InvoiceController::class, 'downloadReceipt']);


Route::get('/{pathMatch}', function () {
    return view('welcome');
})->where('pathMatch', '.*');