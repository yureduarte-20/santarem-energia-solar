<?php

namespace App\Livewire\App\Cliente;

use App\Livewire\Forms\CreateClienteForm;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Throwable;
use WireUi\Traits\Actions;

class Table extends Component
{
    use Actions;
    public function render()
    {
        return view('livewire.app.cliente.table');
    }
}
