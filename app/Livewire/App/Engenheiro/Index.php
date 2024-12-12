<?php

namespace App\Livewire\App\Engenheiro;

use App\Livewire\Forms\CreateEngenheiroForm;
use App\Livewire\Forms\UpdateEngenheiroForm;
use App\Models\Engenheiro;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Index extends Component
{
    use WithPagination, Actions;
    public $query;
    public CreateEngenheiroForm $formCreate;
    public UpdateEngenheiroForm $formUpdate;
    public $createModal = false;
    public $updateModal = false;
    public function create()
    {
        $this->formCreate->verify();
        $this->formCreate->save();
        $this->createModal = false;
        $this->notification()->success(__('Created'));
    }
    public function editModal($id)
    {
        $eng = Engenheiro::where('id',$id)->firstOrFail();
        $this->formUpdate->eng = $eng;
        $this->formUpdate->fill($eng->toArray());
        $this->updateModal = true;
    }   
    public function edit()
    {
        $this->formUpdate->save();
        $this->formUpdate->reset();
        $this->updateModal = false;
        $this->notification()->success('Atualizado com sucesso!');
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
