<?php

namespace App\Livewire\Forms;

use App\Actions\App\Pedido\CreateInstalacaoAction;
use App\Models\Pedido;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateInstalacaoForm extends AbstractForm
{
    public $pedido_id;
    public $data_prevista;
    public $data_instalada = null;
    public function save(): mixed
    {
        $action = new CreateInstalacaoAction;
        return tap(
            $action($this->all()),
            fn($result) => $result and $this->reset()
        );
    }

    public function getRules()
    {
        return  (new CreateInstalacaoAction)->rules();
    }
    public function getValidationAttributes()
    {
        return  (new CreateInstalacaoAction)->attributes();   
    }
    public function  fillFromPedido(Pedido $pedido)
    {
        $this->pedido_id = $pedido->id;
    }
}
