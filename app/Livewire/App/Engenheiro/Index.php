<?php

namespace App\Livewire\App\Engenheiro;

use App\Livewire\Forms\CreateEngenheiroForm;
use App\Models\Engenheiro;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Index extends Component
{
    use WithPagination, Actions;
    public $query;
    public CreateEngenheiroForm $formCreate;
    public $createModal = false;
    public function create()
    {
        $this->formCreate->verify();
        $this->formCreate->save();
        $this->createModal = false;
        $this->notification()->success(__('Created'));
    }
    public function render()
    {
        return view('livewire.app.engenheiro.index', [
            'engs' => Engenheiro::
                when($this->query, fn($query) => $query->where('nome', 'like', $this->query))
                ->paginate(10)
        ]);
    }
}
