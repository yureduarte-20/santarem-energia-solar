<?php

namespace App\Livewire\Forms;

use App\Actions\Fortify\CreateNewUser;
use App\Enums\TipoConta;
use Livewire\Attributes\Validate;
use Livewire\Form;

use function PHPUnit\Framework\returnSelf;

class CreateNewUserForm extends AbstractForm
{
    public $name;
    public $password;
    public $email;
    public $tipo;
    public function save() : mixed
    {
        $this->verify();
        $data =  $this->all();
        $data['password_confirmation'] = $data['password'];
        $action = new CreateNewUser;
        return tap($action->create(
           $data
        ), fn () => $this->reset() );
    }
    public function getRules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'tipo' => 'required|in:'.collect(TipoConta::cases_names())->join(',')
        ];
    }

}
