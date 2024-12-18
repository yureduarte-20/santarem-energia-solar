<?php
namespace App\Actions\App\Engenheiro;

use App\Actions\Fortify\CreateNewUser;
use App\Enums\TipoConta;
use App\Models\Engenheiro;
use Illuminate\Support\Facades\Validator;

class CreateEngenheiroAction
{
    public function getRules()
    {
        return [
            'cpf' => 'required|cpf|unique:engenheiros,cpf',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required|min:3'
        ];
    }
    public function __invoke(array $input, $errorBag = null): Engenheiro
    {
        $validator = Validator::make($input, $this->getRules());
        $validated = $errorBag ? $validator->validateWithBag($errorBag) : $validator->validate();
        $action = new CreateNewUser;
        $validated['password_confirmation'] = $validated['password'];
        $validated['tipo'] = TipoConta::ENGENHEIRO->name;
        $user = $action->create(
            $validated
        );
        $validated['conta_id'] = $user->conta->id;
        return Engenheiro::create($validated);
    }
}