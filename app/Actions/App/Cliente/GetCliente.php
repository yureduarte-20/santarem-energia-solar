<?php
namespace App\Actions\App\Cliente;

use App\Enums\TipoConta;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class GetCliente
{
    public function query()
    {
        $user = Auth::user();
        $conta = $user->conta;
        return match ($conta->tipo) {
            TipoConta::ENGENHEIRO => Cliente::query()->whereHas(
                'pedidos',
                fn($q) => $q->whereHas(
                    'homologacao_engenheiros',
                    fn($q2) => $q2->where('homologacao_engenheiros.engenheiro_id', $conta->engenheiro->id)
                )
            ),
            TipoConta::VENDEDOR => Cliente::query()->whereHas(
                'pedidos',
                fn($q) => $q->where('user_id', $user->id)
            ),
            TipoConta::INSTALADOR, TipoConta::ADMIN => Cliente::query(),
        };
    }
}