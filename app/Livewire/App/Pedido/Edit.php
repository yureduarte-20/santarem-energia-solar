<?php

namespace App\Livewire\App\Pedido;

use App\Enums\TipoRede;
use App\Models\Engenheiro;
use App\Models\Pedido;
use App\Models\TipoDocumento;
use Livewire\Attributes\Url;
use Livewire\Component;

class Edit extends Component
{
    public Pedido $pedido;
    #[Url('cliente')]
    public $cliente_id;

    public $user_id;

    public $data_pedido;
    public $previsao_entrega;
    public $numero;
    public $engenheiros_homologacao = null;
    public $qtde_contratado;
    public $qtde_entregue;
    public $valor_contratual;
    public $valor;
    public $tipo_rede;

    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido;
        $this->fill($this->pedido->toArray());
        $this->engenheiros_homologacao =$this->pedido->homologacao_engenheiros->pluck('id')->toArray();
    }

    public function getRules()
    {
        return [
            'numero' => 'required|unique:pedidos,numero,'.$this->pedido->numero,
            'cliente_id' => 'required|exists:clientes,id',
            'data_pedido' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'previsao_entrega' => 'required|date|after_or_equal:data_pedido',
            'qtde_contratado' => 'required|numeric|min:1',
            'qtde_entregue' => 'required|numeric|min:0',
            'valor_contratual' => 'required|numeric',
            'valor' => 'required|numeric',
            'tipo_rede' => 'required|in:' . join(',', TipoRede::values()),
            'engenheiros_homologacao' => 'nullable|exists:engenheiros,id',
            'documentos.*' => 'required|exists:tipo_documentos,id'
        ];
    }

    public function render()
    {
        return view('livewire.app.pedido.edit',[
            'engenheiros' => Engenheiro::get(['id', 'nome']),
            'documentos_disp' => TipoDocumento::get(['id','nome'])
        ]);
    }
}
