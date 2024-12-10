<?php

use App\Http\Controllers\ClienteController;
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('/clientes', 'app.cliente.index')->name('cliente.index');
    Route::view('/clientes/create', 'app.cliente.create')->name('cliente.create');
    Route::get('/clientes/search', [ClienteController::class, 'search'])->name('cliente.search');

    Route::name('engenheiro.')
        ->prefix('engenheiro')
        ->group(function () {
            Route::view('/', 'app.engenheiro.index')->name('index');

        });
    Route::post('documentos/{pedidoDocumento}', [\App\Http\Controllers\DocumentosUploadController::class, 'store'])->name('documento.store');
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
});
