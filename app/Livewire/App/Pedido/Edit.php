<?php

namespace App\Livewire\App\Pedido;

use App\Enums\StatusPedido;
use App\Enums\TipoConta;
use App\Enums\TipoRede;
use App\Models\Engenheiro;
use App\Models\Pedido;
use App\Models\TipoDocumento;
use App\Models\User;
use App\Notifications\NewProjectNotification;
use App\Services\WhatsappServiceInterface;
use Carbon\Carbon;
use Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use WireUi\Traits\Actions;

class Edit extends Component
{
    use Actions;
    public Pedido $pedido;
    public $instaladores = [];
    protected WhatsappServiceInterface $whatsappService;
    #[Url('cliente')]
    public $cliente_id;

    public $user_id;
    public $data_entrega;

    public $data_pedido;
    public $previsao_entrega;
    public $numero;
    public $engenheiros_homologacao = null;
    public $qtde_contratado;
    public $qtde_pedido;
    public $valor_contratual;
    public $valor;
    public $tipo_rede;
    public $descricao;
    public $rateios;
    public function boot(WhatsappServiceInterface $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }
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
    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido;
        $this->fill($this->pedido->toArray());
        $this->engenheiros_homologacao = $this->pedido->homologacao_engenheiros->pluck('id')->first();
        $this->rateios = $this->pedido->rateios?->toArray();
        $this->instaladores = $this->pedido->instaladores->map->pivot->pluck('user_id')->toArray();
        $this->user_id = $this->pedido->users->map->pivot->pluck('user_id')->toArray();
    }
    public function save()
    {
        $validated = $this->validate($this->getRules());
        $this->pedido->update(
            $this->all()
        );
        if ($this->engenheiros_homologacao) {
            $this->pedido->homologacao_engenheiros()->sync(
                $this->engenheiros_homologacao
            );
        } else {
            $this->pedido->homologacao_engenheiros()->detach();
        }
        $this->pedido->rateios()->delete();
        $rateios = $validated['rateios'];
        if ($rateios) {
            foreach ($rateios as $rateio) {
                $this->pedido->rateios()->create($rateio);
            }
        }
        if ($validated['instaladores']) {
            $this->pedido->instaladores()->sync($validated['instaladores']);
        }
        $this->pedido->users()->sync($validated['user_id'] ?? []);
        $this->notification()->success("Atualizado com sucesso!");
    }
    public function homologar()
    {
        $result = Gate::inspect('homologar', $this->pedido);
        if ($result->denied()) {
            return $this->notification()->error('Não autorizado', 'Você não tem autorização para homologar este projeto');
        }
        if ($this->pedido->status == StatusPedido::ENVIADO_ENGENHEIRO) {
            $this->pedido->status = StatusPedido::HOMOLOGADO;
            $status = $this->pedido->save();
            $status and $this->notification()->success("Atualizado com sucesso");
        }
    }

    public function getRules()
    {
        return [
            'numero' => ['required', Rule::unique('pedidos', 'numero')->ignore($this->pedido->id)],
            'cliente_id' => 'required|exists:clientes,id',
            'data_pedido' => 'required|date',
            'user_id' => 'required|array',
            'user_id.*' => 'required|exists:users,id',
            'previsao_entrega' => 'required|date|after_or_equal:data_pedido',
            'qtde_contratado' => 'required|numeric|min:1',
            'qtde_pedido' => 'required|numeric|min:0',
            'valor_contratual' => 'required|numeric',
            'valor' => 'required|numeric',
            'tipo_rede' => 'nullable|in:' . join(',', TipoRede::values()),
            'engenheiros_homologacao' => 'nullable|exists:engenheiros,id',
            'descricao' => 'nullable',
            'rateios' => 'nullable|array',
            'rateios.*.nome' => 'required|min:3',
            'instaladores' => 'array',
            'instaladores.*' => [
                'required',
                Rule::exists('users', 'id')
            ]
        ];
    }
    public function updateStatus(string $status)
    {
        if (StatusPedido::ENVIADO_ENGENHEIRO->name == $status and $this->pedido->status == StatusPedido::ENVIAR_ENGENHEIRO) {
            if ($this->pedido->pedido_documentos()->where(['entregue' => false, 'enviar_homologacao' => true])->exists()) {
                $this->dialog()->error("Documentação pendente", 'Há documentos que precisam ser anexados');
                return;
            }
            if (
                $this->pedido->homologacao_engenheiros()
                    ->doesntExist()
            ) {
                $this->dialog()->error("O projeto não tem engenheiros");
            }

            $this->pedido->update([
                'status' => StatusPedido::ENVIADO_ENGENHEIRO
            ]);
            $this->pedido->homologacao_engenheiros->each(function (Engenheiro $engenheiro) {
                $engenheiro->conta->user->notifyNow(new NewProjectNotification($this->pedido));
            });
            $this->dialog()->success("Projeto enviado para a homologação.");
        } else if (StatusPedido::FINALIZADO->name == $status and $this->pedido->status == StatusPedido::ENVIADO_ENGENHEIRO) {
            ['data_entrega' => $data_entrega] = $this->validate([
                'data_entrega' => 'date'
            ]);
            $this->pedido->update([
                'entregue' => true,
                'data_entregue' => $data_entrega,
                'status' => StatusPedido::FINALIZADO
            ]);
            $this->dialog()->success("Projeto Finalizado");
        }
        $this->dispatch('pedido-updated');
    }
    public function render()
    {
        return view('livewire.app.pedido.edit', [
            'engenheiros' => Engenheiro::get(),
            'documentos_disp' => TipoDocumento::get(['id', 'nome']),
            'componentId' => $this->getId(),
            'options_instaladores' => User::instaladores()->get(),
            'options_vendedores' => User::whereHas('conta', fn($conta) => $conta->where('tipo', TipoConta::VENDEDOR->name))->get()
        ]);
    }
}
