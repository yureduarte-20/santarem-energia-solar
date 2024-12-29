<?php

namespace App\Http\Controllers;

use App\Actions\App\Pedido\GetPedidos;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {

        return view('app.pedido.index');
    }
    public function edit(Pedido $pedido)
    {
        return view('app.pedido.edit', compact('pedido'));
    }
}
