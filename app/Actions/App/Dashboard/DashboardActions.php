<?php
namespace App\Actions\App\Dashboard;

use App\Actions\App\Pedido\GetPedidos;
use App\Enums\StatusPedido;
use Illuminate\Support\Facades\DB;

class DashboardActions
{
    public function getStatus()
    {
       return (new GetPedidos())
            ->query()
            ->select(DB::raw('count(pedidos.id) as contagem, pedidos.status'))
            ->withCasts(['status' => StatusPedido::class])
            ->groupBy('status')->get();
    }
}
