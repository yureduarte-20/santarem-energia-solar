<?php

namespace App\Livewire\App\Pedido;

use App\Actions\App\Pedido\GetDocumento;
use App\Actions\App\Pendencia\UpdatePendenciaStatusAction;
use App\Enums\TipoConta;
use App\Livewire\Forms\CreatePendenciaForm;
use App\Models\AcessoDocumento;
use App\Models\Pedido;
use App\Models\PedidoDocumento;
use App\Models\Pendencia;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use WireUi\Traits\Actions;

class Documento extends Component
{
    use Actions;
    public Pedido $pedido;
    public CreatePendenciaForm $pendenciaForm;
    public $modalUpload = false;
    public $pendenciaModal = false;
    public $modalDocumento = false;
    public $modalAcesso = false;
    public $tipoDocumento;
    public $docs = [];

    public $acessos = [];

    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido;
        $docs = (new GetDocumento)->query($this->pedido)->orderBy('id')->get();
        $docs->load('tipo_documento');
        $ids = $docs->pluck('id')->toArray();
        $this->docs = array_combine($ids, $docs->toArray());
        $conta = Auth::user()->conta;
        if ($conta->tipo == TipoConta::ENGENHEIRO) {
            $this->pendenciaForm->engenheiro_id = $conta->engenheiro->id;
            $this->pendenciaForm->pedido_id = $pedido->id;
        }
    }
    public function edit($id)
    {
        $result = PedidoDocumento::find($id)->update($this->docs[$id]);
        $result and $this->notification()->success("Visibilidade do arquivo atualizada.");
    }
    public function addDocumento()
    {
        $this->authorize('create', PedidoDocumento::class);
        $this->validate(['tipoDocumento' => 'required|exists:App\Models\TipoDocumento,id']);
        $this->pedido->pedido_documentos()->create([
            'tipo_documento_id' => $this->tipoDocumento,
            'user_id' => Auth::user()->id
        ]);
        $this->notification()->success('Documento adicionado');
        $this->modalDocumento = false;
    }
    public function download($id)
    {
        $doc = PedidoDocumento::find($id);
        $denied = Gate::inspect('view', $doc)->denied();
        if ($denied)
            return $this->notification()->error("Você não tem autorização para acessar esse recurso");
        if ($doc->arquivo?->path and Storage::exists($doc->arquivo->path)) {
            return Storage::download($doc->arquivo->path, $doc->arquivo->nome);
        }
    }
    public function createPendencia()
    {
        $this->pendenciaForm->verify();
        $result = $this->pendenciaForm->save();
        $result and $this->dialog()
            ->success(
                "A pendencia foi cadastrada com sucesso! ",
                "O responsável será notificado e resolverá o mais breve possível."
            );
        $this->pendenciaModal = false;
    }
    public function delete($id)
    {
        $pedidoDoc = PedidoDocumento::find($id);
        $path = $pedidoDoc->arquivo?->path;
        $pedidoDoc->arquivo?->delete();
        $pedidoDoc->delete();
        if ($path and Storage::exists($path)) {
            Storage::delete($path);
        }
        $this->dialog()->success("Deletado com sucesso!");
    }
    public function openModalAcesso($id)
    {
        $doc = PedidoDocumento::findOrFail($id);
        $this->acessos = $doc->acesso_documentos->map->tipo_conta?->map->name->toArray() ?? [];
        $this->modalAcesso = $id;
    }
    public function saveAcessos()
    {
        $docs = PedidoDocumento::findOrFail($this->modalAcesso);
        $docs->acesso_documentos()->delete();
        foreach ($this->acessos as $acceso) {
            $docs->acesso_documentos()->create([
                'tipo_conta' => $acceso
            ]);
        }
        $this->notification()->success("Acesso Atualizado com sucesso!");
        $this->resetExcept('pedido');

    }
    public function pending($id)
    {
        $pendencia = Pendencia::findOrFail($id);
        $action = new UpdatePendenciaStatusAction;
        $action($pendencia) and $this->dialog()->success('A pendencia foi declarada como resolvida', 'O engenheiro será notificado.') ;
    }
    public function render()
    {
        return view('livewire.app.pedido.documento', [
            'tipo_documentos' => TipoDocumento::all(),
            'documentos' => (new GetDocumento)->query($this->pedido)->orderBy('id')->get(),
            'tipos_contas' => TipoConta::cases(),
            'componentId' => $this->getId()
        ]);
    }
}
