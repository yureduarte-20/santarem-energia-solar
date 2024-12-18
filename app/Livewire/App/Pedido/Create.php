<?php

namespace App\Livewire\App\Pedido;

use App\Enums\TipoRede;
use App\Models\Cliente;
use App\Models\Engenheiro;
use App\Models\Pedido;
use App\Models\TipoDocumento;
use App\Models\User;
use App\Services\WhatsappServiceInterface;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;
    #[Url('cliente')]
    public $cliente_id;
    protected WhatsappServiceInterface $whatsappService;

    public $user_id;
    public $documentos = [];

    public $data_pedido;
    public $previsao_entrega;
    public $numero;
    public $engenheiros_homologacao = null ;
    public $qtde_contratado;
    public $qtde_pedido;
    public $valor_contratual;
    public $valor;
    public $tipo_rede;
    public $descricao;
    public $rateios;
    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }
    #[Computed(persist: true)]
    public function user()
    {
        return User::find($this->user_id);
    }

    public function addRateio()
    {
        $this->rateios = $this->rateios ?? [];
        array_push($this->rateios, [ 'nome' => null ]);
    }
    public function removeRateio($key)
    {
        if($this->rateios and array_key_exists($key, $this->rateios)){
            unset($this->rateios[$key]);
        }
    }

    public function getRules()
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
    public function boot(WhatsappServiceInterface $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }
    public function create()
    {
        $this->authorize('create', Pedido::class);
        $validated = $this->validate($this->getRules());
        DB::transaction(function () use ($validated) {
            $pedido = Pedido::create($validated);
            $validated['engenheiros_homologacao'] and $pedido->homologacao_engenheiros()->attach($validated['engenheiros_homologacao']);
            foreach($validated['documentos'] as $doc_id)
            {
                $pedido->pedido_documentos()->create(['tipo_documento_id' => $doc_id, 'user_id' => $this->user()->id ]);
            }
            $rateios = $validated['rateios'];
            if($rateios){
                foreach($rateios as $rateio){
                    $pedido->rateios()->create($rateio);
                }
            }

            $this->dialog([
                'icon' => 'success',
                'title' => __('Created.'),
                'onClose' =>[
                    'method' => 'redirectTo',
                    'params' => route('pedido.edit', $pedido->id)
                ]
            ]);
            $this->reset();
        });
    }
    public function redirectTo($url)
    {
        return $this->redirect($url);
    }

    public function render()
    {
        return view('livewire.app.pedido.create', [
            'engenheiros' => Engenheiro::with('conta.user')->get(),
            'documentos_disp' => TipoDocumento::get(['id','nome'])
        ]);
    }
}
