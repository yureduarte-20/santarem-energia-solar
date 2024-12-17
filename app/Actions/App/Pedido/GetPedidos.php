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

        return match ($conta->type) {
            TipoConta::ADMIN, TipoConta::INSTALADOR  => Pedido::query(),
            TipoConta::VENDEDOR => Pedido::query()->where('user_id', $user->id),
            TipoConta::ENGENHEIRO => Pedido::query()->whereHas(
                'homologacao_engenheiros',
                fn($query) => $query->where('homologacao_engenheiros.engenheiro_id', $user->id)
            ),
        };
    }
}