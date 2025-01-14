<?php

namespace App\Livewire\App\Pedido;

use App\Actions\App\Pedido\CreateRelogioBidirecional;
use App\Livewire\Forms\CreateRelogioBidirecionalForm;
use App\Livewire\Forms\UpdateRelogioBidirecionalForm;
use App\Models\Pedido;
use Livewire\Component;
use WireUi\Traits\Actions;

class RelogioBidirecional extends Component
{
    use Actions;
    public Pedido $pedido;
    public CreateRelogioBidirecionalForm $createForm;
    public UpdateRelogioBidirecionalForm $updateForm;

    public function create()
    {
        $result = $this->createForm->save();
        $result and $this->dialog()->success('Salvo com sucesso!');
    }
    public function update()
    {
        $this->updateForm->verify();
        $result = $this->updateForm->save();
        $result and $this->dialog()->success(
            'Atualizado com sucesso!'
        );
    }
    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido;
        $this->createForm->fillFromPedido($pedido);
        if ($pedido->relogio_bidirecional) {
            $this->updateForm->fillFromPedido($pedido);
        }
    }
    public function render()
    {
        return view('livewire.app.pedido.relogio-bidirecional');
    }
}
