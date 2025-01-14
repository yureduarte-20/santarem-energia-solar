<?php

namespace App\Livewire\Forms;

use App\Actions\App\Pedido\CreateRelogioBidirecional;
use App\Models\Pedido;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateRelogioBidirecionalForm extends AbstractForm
{
    #[Locked]
    public $pedido_id;
    public $data_solicitacao;
    public $observacoes;

    public function fillFromPedido(Pedido $pedido)
    {
        $this->fill([
            'pedido_id' => $pedido->id
        ]);
    }

    public function save(): mixed
    {
        $this->verify();
        $action = new CreateRelogioBidirecional;
        return tap(
            $action($this->all()),
            fn() => $this->resetExcept(['pedido_id'])
        );
    }

    public function rules()
    {
        return (new CreateRelogioBidirecional)->rules();
    }
}
