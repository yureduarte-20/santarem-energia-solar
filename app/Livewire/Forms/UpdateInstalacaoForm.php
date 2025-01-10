<?php

namespace App\Livewire\Forms;

use App\Actions\App\Pedido\UpdateInstalacaoAction;
use App\Models\Instalacao;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateInstalacaoForm extends AbstractForm
{
    public Instalacao $instalacao;
      public $data_prevista;
      public $data_instalada;
      public $observacao;

    public function fillFromInstalacao(Instalacao $instalacao)
    {
        $this->instalacao = $instalacao;
        $this->fill(
            $instalacao->toArray()
        );
    }

    public function save(): mixed
    {
        return (new UpdateInstalacaoAction)($this->instalacao, $this->all());
    }

    public function getRules()
    {
        return  (new UpdateInstalacaoAction)->rules();
    }
    public function getValidationAttributes()
    {
        return  (new UpdateInstalacaoAction)->attributes();   
    }
}
