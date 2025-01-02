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
    public function getFaturamentoPorMes()
    {
        return DB::table('pedidos')
            ->selectRaw("SUM(valor_contratual) as total_valor, date_format(data_pedido, '%m/%Y') as mes")
            ->groupBy('mes')
            ->orderByDesc('mes')
            ->limit(12)
            ->get()->reverse();
    }
    public function getLucroBrutoPorMes()
    {
        return DB::table('pedidos')
            ->selectRaw("(SUM(valor_contratual) - SUM(valor)) as lucro_bruto, date_format(data_pedido, '%m/%Y') as mes")
            ->groupBy('mes')
            ->orderByDesc('mes')
            ->limit(12)
            ->get()->reverse();
    }
}
