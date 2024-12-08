<?php

namespace App\Livewire\Forms;

use App\Actions\Api\GetEnderecoByCep;
use App\Actions\App\Cliente\CreateClienteAction;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateClienteForm extends Form
{
    public $nome;
    public $cpf;
    public $telefone;
    public $email;
    public $endereco = [];

    public function getRules()
    {
        return (new CreateClienteAction)->getRules();
    }

    public function save()
    {
        $validated = $this->validate();
        $action = new CreateClienteAction;
        $action($validated);
        $this->reset();
    }
    public function update()
    {
        if(!isset($this->endereco['cep']))return;
        $str = str($this->endereco['cep'])->replace('-', '');
        if ($str->length() == 8) {
            $endereco = (new GetEnderecoByCep)->getByCep($str);
            $endereco and $this->endereco = [
                ...$this->endereco,
                'rua' => $endereco['logradouro'],
                'bairro' => $endereco['bairro'],
                'cidade' => $endereco['localidade'],
                'uf' => $endereco['uf'],
            ];
        }
    }
}
