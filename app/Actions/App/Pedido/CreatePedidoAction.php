<?php
namespace App\Actions\App\Pedido;

use App\Enums\TipoRede;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreatePedidoAction
{

    public function __invoke(array $input, string $errorBag = null)
    {
        $validator = Validator::make($input, $this->getRules());
        $validated = $errorBag ? $validator->validateWithBag($errorBag) : $validator->validate();
        return DB::transaction(function () use ($validated) {
            $pedido = Pedido::create($validated);
            $validated['engenheiros_homologacao'] and $pedido->homologacao_engenheiros()->attach($validated['engenheiros_homologacao']);
            foreach ($validated['documentos'] as $doc_id) {
                $pedido->pedido_documentos()->create(['tipo_documento_id' => $doc_id, 'user_id' => Auth::user()->id]);
            }
            $rateios = $validated['rateios'];
            if ($rateios) {
                foreach ($rateios as $rateio) {
                    $pedido->rateios()->create($rateio);
                }
            }
            return $pedido;
        });
    }
    public function getRules(): array
    {
        return [
            'numero' => 'required|unique:pedidos,numero',
            'cliente_id' => 'required|exists:clientes,id',
            'data_pedido' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'previsao_entrega' => 'required|date|after_or_equal:data_pedido',
            'qtde_contratado' => 'required|numeric|min:1',
            'qtde_pedido' => 'required|numeric|min:0',
            'valor_contratual' => 'required|numeric',
            'valor' => 'required|numeric',
            'tipo_rede' => 'nullable|in:' . join(',', TipoRede::values()),
            'engenheiros_homologacao' => 'nullable|exists:engenheiros,id',
            'documentos.*' => 'required|exists:tipo_documentos,id',
            'descricao' => 'nullable|min:3',
            'rateios' => 'nullable|array',
            'rateios.*.nome' => 'required|min:3'
        ];
    }
}