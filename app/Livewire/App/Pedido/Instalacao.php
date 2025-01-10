<?php

namespace App\Livewire\App\Pedido;

use App\Livewire\Forms\CreateInstalacaoForm;
use App\Livewire\Forms\UpdateInstalacaoForm;
use App\Models\Pedido;
use Livewire\Attributes\Locked;
use Livewire\Component;
use WireUi\Traits\Actions;

class Instalacao extends Component
{
    use Actions;
    #[Locked]
    public Pedido $pedido;
    public CreateInstalacaoForm $createForm;
    public UpdateInstalacaoForm $updateForm;
    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido;
        $this->createForm->fillFromPedido($pedido);
        if($pedido->instalacao()->exists()){
            $this->updateForm->fillFromInstalacao($pedido->instalacao);
        }
    }

    public function create()
    {
        if ($this->pedido->instalacao()->exists()) {
            return $this->dialog()->error('Instalação já cadastrada');
        }
        $result = $this->createForm->save();
        $result and $this->dialog()->success("Sucesso!", "Previsão de Instalação cadastrada com sucesso!");
        $result and $this->updateForm->fillFromInstalacao($result);
    }
    public function update()
    {
        $result=$this->updateForm->save();
        $result and $this->dialog()->success('Atualizado com sucesso');
    }
    public function render()
    {
        return view('livewire.app.pedido.instalacao');
    }
}
