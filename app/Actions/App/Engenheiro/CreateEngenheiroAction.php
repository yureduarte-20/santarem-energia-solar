<?php
namespace App\Actions\App\Engenheiro;

use App\Models\Engenheiro;
use Illuminate\Support\Facades\Validator;

class CreateEngenheiroAction
{
    public function getRules()
    {
        return [
            'cpf' => 'required|cpf|unique:engenheiros,cpf',
            'nome' => 'required|string|min:3|max:255'
        ];
    }
    public function __invoke(array $input, $errorBag = null): Engenheiro
    {
        $validator = Validator::make($input, $this->getRules());
        $validated = $errorBag ? $validator->validateWithBag($errorBag) : $validator->validate();
        return Engenheiro::create($validated);
    }
}