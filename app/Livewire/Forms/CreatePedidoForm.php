<?php

namespace App\Livewire\Forms;

use App\Actions\App\Pedido\CreatePedidoAction;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreatePedidoForm extends AbstractForm
{
    #[Url('cliente')]
    public $cliente_id;

    public $user_id;
    public $documentos = [];
    public $qtde_contratado;
    public $qtde_pedido;
    public $valor_contratual;
    public $valor;
    public $tipo_rede;
    public $descricao;
    public $engenheiros_homologacao = null;
    public $data_pedido;
    public $previsao_entrega;
    public $numero;
    public $rateios = [];
    public function addRateio()
    {
        $this->rateios = $this->rateios ?? [];
        array_push($this->rateios, ['nome' => null]);
    }
    public function removeRateio($key)
    {
        if ($this->rateios and array_key_exists($key, $this->rateios)) {
            unset($this->rateios[$key]);
        }
    }
    public function getRules()
    {
        $pedido = (new CreatePedidoAction)->getRules();
        return array_merge(
            $pedido
        );
    }
    public function save(): mixed
    {
        $action = new CreatePedidoAction;
        return tap($action($this->all()), fn($result) => $result and $this->reset());
    }
}
