<?php

namespace App\Livewire\App\Pedido;

use App\Actions\App\Pedido\GetDocumento;
use App\Models\Pedido;
use App\Models\PedidoDocumento;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use WireUi\Traits\Actions;

class Documento extends Component
{
    use Actions;
    public Pedido $pedido;
    public $modalUpload = false;
    public $modalDocumento = false;
    public $tipoDocumento;
    public $docs = [];

    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido;
        $docs = (new GetDocumento)->query($this->pedido)->orderBy('id')->get();
        $docs->load('tipo_documento');
        $ids = $docs->pluck('id')->toArray();
        $this->docs = array_combine($ids,$docs->toArray());
    }
    public function edit($id)
    {
        $result = PedidoDocumento::find($id)->update($this->docs[$id]);
        $result and $this->notification()->success("Arquivo visível para engenheiro");
    }
    public function addDocumento()
    {
        $this->authorize('create',PedidoDocumento::class);
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
        $this->authorize('view', $doc);
        if ($doc->arquivo?->path and Storage::exists($doc->arquivo->path)) {
            return Storage::download($doc->arquivo->path, $doc->arquivo->nome);
        }
    }
    public function render()
    {
        return view('livewire.app.pedido.documento', [
            'tipo_documentos' => TipoDocumento::all(),
            'documentos' => (new GetDocumento)->query($this->pedido)->orderBy('id')->get()
        ]);
    }
}
