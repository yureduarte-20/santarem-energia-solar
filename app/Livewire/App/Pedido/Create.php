<?php

namespace App\Livewire\App\Pedido;

use App\Enums\TipoRede;
use App\Models\Engenheiro;
use App\Models\Pedido;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;
    #[Url('cliente')]
    public $cliente_id;

    public $user_id;
    public $documentos = [];

    public $data_pedido;
    public $previsao_entrega;
    public $numero;
    public $engenheiros_homologacao ;
    public $qtde_contratado;
    public $qtde_entregue;
    public $valor_contratual;
    public $valor;
    public $tipo_rede;

    public function getRules()
    {
        return [
            'numero' => 'required|unique:pedidos,numero',
            'cliente_id' => 'required|exists:clientes,id',
            'data_pedido' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'previsao_entrega' => 'required|date|after_or_equal:data_pedido',
            'qtde_contratado' => 'required|numeric|min:1',
            'qtde_entregue' => 'required|numeric|min:1',
            'valor_contratual' => 'required|numeric',
            'valor' => 'required|numeric',
            'tipo_rede' => 'required|in:' . join(',', TipoRede::values()),
            'engenheiros_homologacao' => 'required|exists:engenheiros,id',
            'documentos.*' => 'required|exists:tipo_documentos,id'
        ];
    }

    public function create()
    {
        $validated = $this->validate($this->getRules());
        DB::transaction(function () use ($validated) {
            $pedido = Pedido::create($validated);
            $pedido->homologacao_engenheiros()->attach($validated['engenheiros_homologacao']);
            foreach($validated['documentos'] as $doc_id)
            {
                $pedido->pedido_documentos()->create(['tipo_documento_id' => $doc_id]);
            }
            $this->dialog()->success(__("Created."));
            $this->reset();
        });
    }

    public function render()
    {
        return view('livewire.app.pedido.create', [
            'engenheiros' => Engenheiro::get(['id', 'nome']),
            'documentos_disp' => TipoDocumento::get(['id','nome'])
        ]);
    }
}
