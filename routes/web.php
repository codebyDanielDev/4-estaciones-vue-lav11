<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CalcularController;

use App\Http\Controllers\Crud\ProductoController;

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HistoryPanelController;
use App\Http\Controllers\PDFController;

Route::middleware(['auth'])->group(function () {

    Route::redirect('/', '/dashboard');
    // Ruta para el dashboard de administración utilizando el controlador

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/calculate', [CalcularController::class, 'index'])->name('calculate');
    Route::delete('/calcular/archive/{id}', [CalcularController::class, 'archive'])->name('calcular.archive');
    Route::post('/calcular/restore/{id}', [CalcularController::class, 'restore'])->name('calcular.restore');
    Route::post('/calcular/store', [CalcularController::class, 'store']);
    Route::post('/calcular/store-multiple', [CalcularController::class, 'storeMultiple']);
    Route::get('/calcular/get-list-productos', [CalcularController::class, 'getListProductos']);
    Route::post('/calcular-y-guardar', [CalcularController::class, 'calcularYGuardar']);
    Route::get('/export-users', [CalcularController::class, 'export']);

    Route::get('/export-transaction-details/{transactionId}', [CalcularController::class, 'exportTransactionDetails']);



    Route::get('/report', [ReportController::class, 'index'])->name('report');



    Route::get('/history', [HistoryPanelController::class, 'history'])->name('history');
    Route::get('/fetch-transactions', [HistoryPanelController::class, 'fetchTransactions'])->name('fetch-transactions');

    // Route::get('/products', [ProductoController::class, 'index'])->name('products.index');







    Route::resource('products', ProductoController::class)->names([
        'index' => 'products.index',
        'create' => 'products.create',
        'show' => 'products.show',
        'edit' => 'products.edit',
        'store' => 'products.store', // Asegúrate de tener esta línea
    ]);


    Route::get('/categorias', [ProductoController::class, 'getCategorias'])->name('categorias.get');
    Route::get('/unidades', [ProductoController::class, 'getUnidades'])->name('unidades.get');

    Route::get('/search', [ProductoController::class, 'search'])->name('products.search');

    Route::get('/generar-pdf', [PDFController::class, 'generarPDF']);
});
