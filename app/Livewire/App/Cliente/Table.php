<?php

namespace App\Livewire\App\Cliente;

use App\Actions\App\Cliente\GetCliente;
use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Table extends Component
{
    use Actions, WithPagination;
    public $query;

    public function delete($id)
    {
        $cliente = Cliente::findOrFail($id);
        $this->authorize('delete', $cliente);
        $exists = $cliente->pedidos()->exists();
        if($exists){
            return $this->dialog()->error('Não é possível apagar o cliente', 'Há pedidos por esse cliente') ;
        }
        $cliente->delete() and $this->dialog()->success('Apagado com sucesso!') ;
    }
    public function render()
    {
        return view('livewire.app.cliente.table', [
            'clientes' => (new GetCliente)->query()
            ->when($this->query, fn($query) => $query->where('nome', 'like', '%'.$this->query.'%')
            ->orWhere('cpf', 'like', $this->query."%") )
            ->paginate(10)
        ]);
    }
}
