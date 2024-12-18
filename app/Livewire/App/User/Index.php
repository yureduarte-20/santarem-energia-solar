<?php

namespace App\Livewire\App\User;

use App\Livewire\Forms\CreateNewUserForm;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;

class Index extends Component
{
    use Actions;
    public CreateNewUserForm $createForm;
    public $modalCreate = false;
    public function create()
    {
        $this->createForm->save();
        $this->notification()->success('Criado com sucesso!');
        $this->modalCreate = false;
    }
    public function render()
    {
        return view('livewire.app.user.index', [
            'users' => User::all()
        ]);
    }
}
