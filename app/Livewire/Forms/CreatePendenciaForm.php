<?php

namespace App\Livewire\Forms;

use App\Actions\App\Pendencia\CreatePendenciaAction;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreatePendenciaForm extends AbstractForm
{
    public $pedido_id;
    public $engenheiro_id;
    public $conteudo;

    public function getRules()
    {
        return (new CreatePendenciaAction)->getRules();
    }
    public function save(): mixed
    {
        $action = new CreatePendenciaAction;
        return tap($action($this->all()), fn() => $this->resetExcept(['pedido_id', 'engenheiro_id']));
    }
}
