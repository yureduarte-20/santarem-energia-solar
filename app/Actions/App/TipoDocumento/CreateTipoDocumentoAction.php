<?php
namespace App\Actions\App\TipoDocumento;

use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Validator;

class CreateTipoDocumentoAction
{
    public function getRules()
    {
        return [
            'nome' => 'required|unique:'.TipoDocumento::class.',nome'
        ];
    }
    public function __invoke(array $input, string $errorBag = null)
    {
        
        $validator = Validator::make($input,$this->getRules());
        $validated = $errorBag ? $validator->validateWithBag($errorBag) : $validator->validate();
        return TipoDocumento::create($validated);
    }
}