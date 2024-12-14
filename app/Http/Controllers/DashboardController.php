<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $faturamento_valor_final = Pedido::sum('valor_contratual');
        $lucro = Pedido::selectRaw('(SUM(valor_contratual) - SUM(valor)) as lucro')->first()->lucro;
        return view('dashboard', compact('faturamento_valor_final', 'lucro'));
    }
}
