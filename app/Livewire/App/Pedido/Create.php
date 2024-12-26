<?php

namespace App\Livewire\App\Pedido;

use App\Enums\TipoConta;
use App\Enums\TipoRede;
use App\Livewire\Forms\CreatePedidoForm;
use App\Models\Cliente;
use App\Models\Engenheiro;
use App\Models\Pedido;
use App\Models\TipoDocumento;
use App\Models\User;
use App\Services\WhatsappServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public CreatePedidoForm $form;
    protected WhatsappServiceInterface $whatsappService;

    public function mount()
    {
        $this->form->user_id = auth()->user()->id;
    }
    #[Computed(persist: true)]
    public function user()
    {
        return User::find($this->user_id);
    }

    public function addRateio()
    {
        $this->form->addRateio();
    }
    public function removeRateio($key)
    {
        $this->form->removeRateio($key);
    }
    public function boot(WhatsappServiceInterface $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }
    public function create()
    {
        $this->authorize('create', Pedido::class);
        $this->form->verify();
        $result = $this->form->save();
        $result and $this->notification()->success(
            'Pedido Criado com sucesso'
        );
        $result and match (true) {
            Gate::inspect('update', $result)->allowed() => $this->redirect(route('pedido.edit', $result)),
            default => null
        };
        $result and session()->flash('success', 'Pedido Criado com sucesso');
    }
    public function redirectTo($url)
    {
        return $this->redirect($url);
    }

    public function render()
    {
        return view('livewire.app.pedido.create', [
            'engenheiros' => Engenheiro::with('conta.user')->get(),
            'documentos_disp' => TipoDocumento::get(['id', 'nome']),
            'options_vendedores' => User::whereHas('conta', fn($conta) => $conta->where('tipo', TipoConta::VENDEDOR->name))->get()
        ]);
    }
}
