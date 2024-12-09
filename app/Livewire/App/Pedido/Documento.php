<?php

namespace App\Livewire\App\Pedido;

use App\Models\Pedido;
use App\Models\PedidoDocumento;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use WireUi\Traits\Actions;

class Documento extends Component
{
    use Actions;
    public Pedido $pedido;
    public $modalUpload = false;
    public $tipoDocumento;

    public function mount(Pedido $pedido)
    {
        $docs = $pedido->pedido_documentos;
        $docs->load('tipo_documento');
        $this->pedido = $pedido;
    }
    public function addDocumento()
    {
       $this->validate(['tipoDocumento' => 'required|exists:App\Models\TipoDocumento,id']);
        $this->pedido->pedido_documentos()->create([
            'tipo_documento_id' => $this->tipoDocumento
        ]);
        $this->notification()->success('Documento adicionado');
    }
    public function download($id)
    {
        $doc = PedidoDocumento::find($id);
        if($doc->arquivo?->path and Storage::exists($doc->arquivo->path)){
            return Storage::download($doc->arquivo->path, $doc->arquivo->nome);
        }
    }
    public function render()
    {
        return view('livewire.app.pedido.documento',[
            'tipo_documentos' => TipoDocumento::all()
        ]);
    }
}
