<?php
namespace App\Actions\App\Dashboard;

use App\Actions\App\Pedido\GetPedidos;
use App\Enums\StatusPedido;
use Illuminate\Database\Eloquent\Collection;
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
    public function pendencias()
    {
        return DB::table('pendencias')
            ->select(DB::raw('COALESCE(SUM(atendida), 0) AS atendidas, COALESCE (SUM(
                CASE atendida
                    WHEN 1 THEN 0
                    WHEN 0 THEN 1
                END
            ), 0) as nao_atendidas'))
            ->first();

    }
    public function pendencias_documentos()
    {
        return DB::table('pedido_documentos')
            ->select(DB::raw('CAST(SUM(entregue) AS SIGNED) AS entregue,
            CAST(SUM( CASE entregue
                WHEN 1 THEN 0
                WHEN 0 THEN 1
            END
        ) AS SIGNED) AS nao_entregue'))->first();

    }
}
