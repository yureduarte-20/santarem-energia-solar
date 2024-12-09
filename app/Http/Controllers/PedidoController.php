<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        return view('app.pedido.index', [
            'pedidos' => Pedido::orderByDesc('created_at')->paginate(10)
        ]);
    }
    public function edit(Pedido $pedido)
    {
        return view('app.pedido.edit', compact('pedido'));
    }
}
