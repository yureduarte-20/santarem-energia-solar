<?php

namespace App\Livewire\Forms;

use App\Actions\App\Engenheiro\UpdateEngenheiroAction;
use App\Models\Engenheiro;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateEngenheiroForm extends AbstractForm
{
    public ?Engenheiro $eng;

    public $name;
    public $cpf;
    public $email;
    public function save(): mixed
    {   
        $this->verify();
        $action = new UpdateEngenheiroAction;
        return $action($this->eng, $this->all());
    }
    public function fillFromEngenheiro(Engenheiro $engenheiro): void
    {
        $this->eng = $engenheiro;
        $this->fill($engenheiro->toArray());
        $this->fill($engenheiro->conta->user->toArray());
    }
    public function getRules()
    {
        return (new UpdateEngenheiroAction)->getRules($this->eng);
    }
}
