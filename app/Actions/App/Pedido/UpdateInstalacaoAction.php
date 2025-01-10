<?php
namespace App\Actions\App\Pedido;

use App\Enums\TipoRede;
use App\Models\Instalacao;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateInstalacaoAction
{
    public function rules()
    {
        return [
            'data_prevista' => 'required|date',
            'data_instalada' => 'nullable|date|after_or_equal:data_prevista',
            'observacao' => 'nullable|string|min:3'
        ];
    }

    public function __invoke(Instalacao $instalacao,array $input, string $bag = null)
    {
        $validator = Validator::make($input, $this->rules(), $this->messages(), $this->attributes());
        $validated = $bag ? $validator->validateWithBag($bag) : $validator->validated();
        return $instalacao->update($validated);
    }

    public function messages()
    {
        return [];
    }
    public function attributes()
    {
        return [
            'pedido_id' => 'pedido',
            'data_prevista' => 'data prevista de instalação',
            'data_instalada' => 'data de instalação'
        ];
    }
}