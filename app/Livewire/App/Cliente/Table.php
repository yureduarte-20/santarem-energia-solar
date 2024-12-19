<?php

namespace App\Livewire\App\Cliente;

use App\Actions\App\Cliente\GetCliente;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Table extends Component
{
    use Actions, WithPagination;
    public $query;
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
