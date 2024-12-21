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
            TipoConta::ADMIN => PedidoDocumento::query()->when(
                $pedido,
                fn($q) => $q->where('pedido_id', $pedido->id)
            ),

            TipoConta::INSTALADOR => PedidoDocumento::query()->when(
                $pedido,
                fn($q) => $q->where('pedido_id', $pedido->id)
            )->whereHas('acesso_documentos', fn($q) => $q->where('tipo_conta', TipoConta::INSTALADOR->name)),

            TipoConta::VENDEDOR => PedidoDocumento::query()->when(
                $pedido,
                fn($q) => $q->where('pedido_id', $pedido->id)
            )->whereHas('acesso_documentos', fn($q) => $q->where('tipo_conta', TipoConta::VENDEDOR->name)),
            
            TipoConta::ENGENHEIRO => PedidoDocumento::query()
                ->when($pedido, fn($q) => $q->where('pedido_id', $pedido->id))
                ->where('user_id', $user->id)
                ->orWhere(
                    fn($query) =>
                    $query->whereHas(
                        'pedido.homologacao_engenheiros',
                        fn($query) => $query
                            ->when($pedido, fn($q2) => $q2->where('homologacao_engenheiros.pedido_id', $pedido->id))
                            ->where('homologacao_engenheiros.engenheiro_id', $conta->engenheiro->id)
                    )->whereHas('acesso_documentos', fn($q3) => $q3->where('tipo_conta', TipoConta::ENGENHEIRO->name))
                )

        };
    }
}