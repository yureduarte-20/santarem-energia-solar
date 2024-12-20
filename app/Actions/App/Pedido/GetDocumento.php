<?php
namespace App\Actions\App\Pedido;

use App\Enums\TipoConta;
use App\Models\Pedido;
use App\Models\PedidoDocumento;
use Illuminate\Support\Facades\Auth;

class GetDocumento
{
    public function query(Pedido $pedido = null)
    {
        $user = Auth::user();
        $conta = $user->conta;

        return match ($conta->tipo) {
            TipoConta::ADMIN, TipoConta::INSTALADOR, TipoConta::VENDEDOR => PedidoDocumento::query()->when(
                $pedido,
                fn($q) => $q->where('pedido_id', $pedido->id)
            ),
            TipoConta::ENGENHEIRO => PedidoDocumento::query()
                ->when($pedido, fn($q) => $q->where('pedido_id', $pedido->id))
                ->where('user_id', $user->id)
                ->orWhere(fn($query) => $query->where('enviar_homologacao', true)
                    ->whereHas('pedido.homologacao_engenheiros', fn($query) => $query
                    ->when($pedido, fn($q2) => $q2->where('homologacao_engenheiros.pedido_id', $pedido->id)  )
                    ->where('homologacao_engenheiros.engenheiro_id', $conta->engenheiro->id) ) )

        };
    }
}