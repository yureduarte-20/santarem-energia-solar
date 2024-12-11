<?php

namespace App\Livewire\App\Cliente;

use App\Livewire\Forms\UpdateClienteForm;
use App\Models\Cliente;
use Livewire\Component;
use WireUi\Traits\Actions;

class Edit extends Component
{
    use Actions;
    public Cliente $cliente;
    public UpdateClienteForm $form;
    public function mount(Cliente $cliente)
    {
        $this->cliente = $cliente;
        $this->form->cliente = $cliente;
        $this->form->fill($cliente->toArray());
        $this->form->endereco = $cliente->endereco->toArray();
    }
    public function submit()
    {
        $this->form->verify();
        $result = $this->form->save();
        $result and $this->notification()->success("Atualizado com sucesso");
    }
    public function render()
    {
        return view('livewire.app.cliente.edit');
    }
}
