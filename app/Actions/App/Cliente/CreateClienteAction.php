<?php
namespace App\Actions\App\Cliente;

use App\Models\Cliente;
use Illuminate\Database\Events\TransactionBeginning;
use Validator;

class CreateClienteAction
{
    public function getRules()
    {
        return [
            'nome' => 'required|min:3|max:255',
            'cpf' => 'required|cpf|unique:clientes,cpf',
            'telefone' => 'nullable|regex:/^(\+[0-9]{2})?([0-9]{2})\s?[0-9]{8,9}$/',
            'email' => 'nullable|email',
            'endereco' => 'required|array',
            'endereco.rua' => 'nullable|string|min:3',
            'endereco.numero' => 'nullable|string|min:1',
            'endereco.bairro' => 'nullable|string|min:3',
            'endereco.cidade' => 'required|string|min:3',
            'endereco.uf' => 'required|string|max:2',
            'endereco.cep' => 'required|string|max:8'
        ];
    }
    public function __invoke(array $input)
    {
        $data = Validator::make($input, $this->getRules())->validate();

        return tap(Cliente::create($data), function(Cliente $cliente) use($data){
            $cliente->endereco()->create($data['endereco']);
        });
    }
}
