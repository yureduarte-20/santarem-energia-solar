<?php

namespace App\Livewire\Forms;


use App\Actions\App\Engenheiro\CreateEngenheiroAction;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateEngenheiroForm extends AbstractForm
{
    public $name;
    public $cpf;
    public $password;

    public $email;
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
