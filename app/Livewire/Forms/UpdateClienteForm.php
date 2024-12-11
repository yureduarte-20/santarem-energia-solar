<?php

namespace App\Livewire\Forms;

use App\Actions\App\Cliente\UpdateClienteAction;
use App\Models\Cliente;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateClienteForm extends AbstractForm
{
    #[Locked]
    public Cliente $cliente;
    public $nome;
    public $cpf;
    public $telefone;
    public $email;
    public $endereco = [];
    public function save(): mixed
    {
        $action = new UpdateClienteAction; 
        return $action(
            $this->cliente,
            $this->all()
        );
    }
    public function getRules()
    {
        return (new UpdateClienteAction)->getRules(
            $this->cliente
        );
    }
}
