<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/invoice', [InvoiceController::class, 'create'])->name('invoice.create');
Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
Route::get('/invoice/print', [InvoiceController::class, 'print'])->name('invoice.print');
Route::get('/change-language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ku', 'ar'])) {
        App::setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('change-language');
