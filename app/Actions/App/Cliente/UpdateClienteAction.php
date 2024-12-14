<?php
namespace App\Actions\App\Cliente;

use App\Enums\TipoTelhado;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateClienteAction 
{
    public function __invoke(Cliente $cliente, array $input) 
    {
        $valitaded = Validator::make(
            $input,
            $this->getRules($cliente),
        )->validate();
        return tap(
            $cliente->update($valitaded),
            function ($validator) use ($valitaded, $cliente) {
                $cliente->endereco->update($valitaded['endereco']);
            }
        );
    }
    public function getRules(Cliente $cliente)
    {
        return [
            'nome' => 'required|min:3|max:255',
            'cpf' => ['required','cpf', Rule::unique('users', 'cpf')->ignore($cliente->id)],
            'telefone' => 'nullable|regex:/^(\+[0-9]{2})?([0-9]{2})\s?[0-9]{8,9}$/',
            'email' => 'nullable|email',
            'endereco' => 'required|array',
            'endereco.rua' => 'nullable|string|min:3',
            'endereco.numero' => 'nullable|string|min:1',
            'endereco.bairro' => 'nullable|string|min:3',
            'endereco.cidade' => 'required|string|min:3',
            'endereco.uf' => 'required|string|max:2',
            'endereco.cep' => 'required|string|max:10',
            'endereco.tipo_telhado' => 'required|in:'.join(',',TipoTelhado::values())
        ];
    }
}