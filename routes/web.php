<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\TipoDocumentoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(ClienteController::class)
    ->prefix('clientes')
    ->name('cliente.')
    ->group(function () {
        Route::view('/', 'app.cliente.index')->name('index');
        Route::view('/create', 'app.cliente.create')->name('create');
        Route::get('/search', [ClienteController::class, 'search'])->name('search');
        Route::get('/{cliente}/edit', 'edit')->name('edit');
    });

    Route::name('engenheiro.')
        ->prefix('engenheiro')
        ->group(function () {
            Route::view('/', 'app.engenheiro.index')->name('index');

        });
    Route::post('documentos/{pedidoDocumento}', [\App\Http\Controllers\DocumentosUploadController::class, 'store'])->name('documento.store');
    Route::post('documentos/{pedido}/pedido', [\App\Http\Controllers\DocumentosUploadController::class, 'storeFromPedido'])->name('documento.store-pedido');
    Route::name('pedido.')
        ->prefix('pedido')
        ->controller(PedidoController::class)
        ->group(function () {
            Route::view('/create', 'app.pedido.create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/{pedido}', 'edit')->name('edit');
        });

    Route::controller(TipoDocumentoController::class)
        ->prefix('tipo-documento')
        ->name('tipo-documento.')
        ->group(function () {
            Route::post('/', 'store')->name('store');
            Route::get("/search", 'search')->name('search');
        });
    Route::view('usuarios','app.user.index')->name('user.index');
});
