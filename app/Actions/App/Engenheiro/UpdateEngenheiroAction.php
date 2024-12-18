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
        $result = $eng->update($validated);
        $result and $result = $eng->conta->user->update($validated);
        return $result;
    }
    public function getRules(Engenheiro $eng)
    {
        return [
            'cpf' => ['required','cpf', Rule::unique('engenheiros', 'cpf')->ignore($eng->id)],
            'name' => 'required|string|min:3|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($eng->conta->user_id)]
        ];
    }
}