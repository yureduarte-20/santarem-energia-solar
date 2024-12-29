<?php

namespace App\Http\Controllers;

use App\Actions\App\Dashboard\DashboardActions;
use App\Models\Pedido;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardActions $actions
    )
    {

    }
    public function index()
    {
        $faturamento_valor_final = Pedido::sum('valor_contratual');
        $lucro = Pedido::selectRaw('(SUM(valor_contratual) - SUM(valor)) as lucro')->first()->lucro;
        $dados = $this->actions->getStatus()->map(function ($item){
            return [
                'x' => $item->status->label(),
                'y' => $item->contagem
            ];
        });
        return view('dashboard', compact('faturamento_valor_final', 'lucro', 'dados'));
    }
}
