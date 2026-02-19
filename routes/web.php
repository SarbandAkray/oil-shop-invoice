<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/* ── New invoice form ──────────────────────────────────────── */
Route::get('/', [InvoiceController::class, 'create'])->name('invoice.create');

/* ── Invoice CRUD ──────────────────────────────────────────── */
Route::post  ('/invoices',          [InvoiceController::class, 'store'])  ->name('invoice.store');
Route::get   ('/invoices',          [InvoiceController::class, 'index'])  ->name('invoices.index');
Route::get   ('/invoices/{id}',     [InvoiceController::class, 'show'])   ->name('invoice.show');
Route::get   ('/invoices/{id}/edit',[InvoiceController::class, 'edit'])   ->name('invoice.edit');
Route::put   ('/invoices/{id}',     [InvoiceController::class, 'update']) ->name('invoice.update');
Route::delete('/invoices/{id}',     [InvoiceController::class, 'destroy'])->name('invoice.destroy');

/* ── Settings ─────────────────────────────────────────────── */
Route::get ('/settings', [SettingsController::class, 'edit'])  ->name('settings.edit');
Route::put ('/settings', [SettingsController::class, 'update'])->name('settings.update');

/* ── Language switcher ─────────────────────────────────────── */
Route::get('/change-language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ku', 'ar'])) {
        App::setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('change-language');
