<?php
namespace App\Actions\App\Engenheiro;

use App\Models\Engenheiro;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateEngenheiroAction
{
    public function __invoke(Engenheiro $eng, array $input, $errorBag = null)
    {
        $valitador = Validator::make($input,$this->getRules($eng));
        $validated = $errorBag ? $valitador->validateWithBag($errorBag) : $valitador->validate();
        return $eng->update($validated);
    }
    public function getRules(Engenheiro $eng)
    {
        return [
            'cpf' => ['required','cpf', Rule::unique('engenheiros', 'cpf')->ignore($eng->id)],
            'nome' => 'required|string|min:3|max:255'
        ];
    }
}