<?php

namespace App\Actions\App\Pedido;

use App\Actions\App\AbstractCrudAction;
use App\Enums\StatusRelogioBidirecional;
use App\Models\RelogioBidirecional;

class CreateRelogioBidirecional extends AbstractCrudAction
{
    public function __invoke(array $input)
    {
        $validated = $this->validate($input);
        return RelogioBidirecional::create(
            array_merge(
                $validated,
                ['status' => StatusRelogioBidirecional::SOLICITADO->name ]
            )
        );
    }
    public function rules()
    {
        return  [
            'data_solicitacao' => 'required|date',
            'pedido_id' => 'required|exists:pedidos,id',
            'observacoes' => 'nullable|string|min:3'
        ];
    }
}
