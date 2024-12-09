<?php

namespace App\Livewire\App\Cliente;

use App\Livewire\Forms\CreateClienteForm;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;
use WireUi\Traits\Actions;

class Table extends Component
{
    use Actions, WithPagination;
    public $query;
    public function render()
    {
        return view('livewire.app.cliente.table', [
            'clientes' => Cliente::when($this->query, fn($query) => $query->where('nome', 'like', '%'.$query.'%')
            ->orWhere('cpf', 'like', $this->query."%") )
            ->paginate(10)
        ]);
    }
}
