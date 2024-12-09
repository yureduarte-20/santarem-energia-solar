<?php

namespace App\Livewire\App\Cliente;

use App\Livewire\Forms\CreateClienteForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Throwable;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;
    public CreateClienteForm $form;
    public function updatedForm()
    {
        $this->form->update();
    }
    public function submit()
    {
        $cliente = $this->form->save();
        $this->notification()->success(__('Created.'));
        $this->redirect(route('pedido.create', [ 'cliente' => $cliente->id ]));
    }
    
    public function render()
    {
        return view('livewire.app.cliente.create');
    }
}
