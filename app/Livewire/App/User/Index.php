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
    public function inactive($id)
    {
        if($id == auth()->user()->id){
            return $this->notification()->error('Você não pode inativar sua própria conta!');
        }
        User::whereId($id)->update([
            'active' => false
        ]);
        $this->notification()->success("Acesso do usuário negado!");        
    }
    public function render()
    {
        return view('livewire.app.user.index', [
            'users' => User::all(),
            'componentId' => $this->getId()
        ]);
    }
}
