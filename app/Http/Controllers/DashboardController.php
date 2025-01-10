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
        $dados = $this->actions->getStatus()->map(function ($item){
            return (object)[
                'status' => $item->status->label(),
                'contagem' => $item->contagem,
                'status_value' =>$item->status->name
            ];
        });
        $faturamento_mes = $this->actions->getFaturamentoPorMes();
        $lucro_bruto_mes = $this->actions->getLucroBrutoPorMes();

        return view('dashboard', [
            'faturamento_mes' => $faturamento_mes,
            'lucro_bruto_mes' => $lucro_bruto_mes,
            'dados' => $dados,
            'pendencias' => $this->actions->pendencias(),
            'pendencias_documentos' => $this->actions->pendencias_documentos(),
            'trt' => $this->actions->trt()
        ]);
    }
}
