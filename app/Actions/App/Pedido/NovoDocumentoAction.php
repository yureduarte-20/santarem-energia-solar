<?php

namespace App\Actions\App\Pedido;

use App\Enums\TipoConta;
use App\Models\PedidoDocumento;
use App\Models\User;
use App\Notifications\NewDocAttachedNotification;
use Illuminate\Support\Facades\Notification;
use Validator;

class NovoDocumentoAction
{
    public function __invoke(
        PedidoDocumento $pedidoDocumento
    ) {
        $users_ids = [];
        if ($pedidoDocumento->acesso_documentos()->where('tipo_conta', TipoConta::ENGENHEIRO->name)) {
            $users_ids = $pedidoDocumento->pedido->homologacao_engenheiros->map->conta->map->user_id->toArray();
        }
        $users_ids = array_merge(
            $users_ids,
            User::whereHas('conta', fn($q) => $q->where('tipo', TipoConta::ADMIN->name))->get('id')->pluck('id')->toArray()
        );
        User::whereIn('id', $users_ids)->each(function (User $user) use ($pedidoDocumento) {
            $user->notifyNow(
                new NewDocAttachedNotification(
                    $pedidoDocumento
                )
            );
        });
    }

}