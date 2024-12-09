<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
    Route::name('pedido.')
        ->prefix('pedido')
        ->group(function () {
            Route::view('/create', 'app.pedido.create')->name('create');
        });
});
