<?php
namespace App\Actions\App\Pedido;

use App\Enums\TipoConta;
use App\Models\Conta;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class GetPedidos
{
    public function query()
    {
        $user = Auth::user();
        $conta = Auth::user()->conta;

        return match ($conta->tipo) {
            TipoConta::ADMIN => Pedido::query(),
            TipoConta::INSTALADOR => Pedido::query()->whereHas(
                'instaladores',
                fn($q) => $q->where('instaladores_pedidos.user_id', $user->id)
            ),
            TipoConta::VENDEDOR => Pedido::query()->whereHas('user', fn($q) =>  $q->where('pedido_user.user_id', $user->id)),
            TipoConta::ENGENHEIRO => Pedido::query()->whereHas(
                'homologacao_engenheiros',
                fn($query) => $query->where('homologacao_engenheiros.engenheiro_id', $conta->engenheiro->id)
            ),
        };
    }
}