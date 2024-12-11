<?php

namespace App\Livewire\App\User;

use App\Livewire\Forms\CreateNewUserForm;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public CreateNewUserForm $createForm;
    public $modalCreate = false;
    public function create()
    {
        $this->createForm->save();
    }
    public function render()
    {
        return view('livewire.app.user.index', [
            'users' => User::all()
        ]);
    }
}
