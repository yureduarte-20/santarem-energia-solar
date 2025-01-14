<?php

namespace App\Livewire\Forms;

use App\Actions\App\Pedido\UpdateRelogioBidirecional;
use App\Models\RelogioBidirecional;
use App\Models\Pedido;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateRelogioBidirecionalForm extends AbstractForm
{
    public RelogioBidirecional $relogio;
    public $data_solicitacao;
    public $data_retorno;
    public $status;
    public $observacoes;

    public function fillFromPedido(Pedido $pedido)
    {
        $this->fill($pedido->relogio_bidirecional->toArray());
        $this->relogio = $pedido->relogio_bidirecional;
    }
    public function fillFromModel(RelogioBidirecional $relogio_bidirecional)
    {
        $this->fill($relogio_bidirecional->toArray());
        $this->relogio = $relogio_bidirecional;
    }
    public function save(): mixed
    {
        $this->verify();
        $action = new UpdateRelogioBidirecional(
            $this->relogio
        );
        return $action->update($this->all());
    }

    public function rules()
    {
        return (new UpdateRelogioBidirecional(
            $this->relogio
        ))->rules();
    }
    public function getValidationAttributes()
    {
        return (new UpdateRelogioBidirecional(
            $this->relogio
        ))->attributes();
    }
}
