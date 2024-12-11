<?php

namespace App\Livewire\Forms;


use App\Actions\App\Engenheiro\CreateEngenheiroAction;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateEngenheiroForm extends AbstractForm
{
    public $nome;
    public $cpf;

    public function getRules() : array
    {
        return (new CreateEngenheiroAction)->getRules();
    }

    public function save(): mixed
    {
        $action = new CreateEngenheiroAction;
        return tap(
            $action($this->all()),
            fn() => $this->reset()
        );
    }
}
