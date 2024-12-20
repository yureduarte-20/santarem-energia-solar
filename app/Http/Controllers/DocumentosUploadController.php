<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDocumento;
use App\Actions\App\Arquivo\CreateArquivoAction;
use App\Actions\App\Pedido\NovoDocumentoAction;
use App\Models\TipoDocumento;
use App\Notifications\NewDocAttachedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocumentosUploadController
{
    public function store(Request $request, PedidoDocumento $pedidoDocumento)
    {
        $validated = $request->validate([
            'arquivo' => 'required|file|mimes:png,jpg,docx,pdf,doc',
            
        ]);
        $request->file();
        $action = new CreateArquivoAction;

        $action->from_uploaded_file(
            $pedidoDocumento,
            $validated['arquivo']
        );
        $notify = new NovoDocumentoAction;
        $notify($pedidoDocumento);
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Arquivo enviado com sucesso!']);
        }
        session()->flash('success', 'Arquivo enviado com sucesso!');
        return back()->with('success', 'Arquivo enviado com sucesso!');
    }
    public function storeFromPedido(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'arquivo' => 'required|file|mimes:png,jpg,docx,pdf,doc',
            'tipo_documento_id' => 'required|exists:' . TipoDocumento::class . ',id',
            'enviar_homologacao' => 'required|in:on,off'
        ]);
        
        $success = DB::transaction(function () use ($validated, $pedido) {
            $pedidoDocumento = $pedido->pedido_documentos()->create([
                'user_id' => Auth::user()->id,
                'tipo_documento_id' => $validated['tipo_documento_id'],
                'enviar_homologacao' => $validated['enviar_homologacao'] == 'on'
            ]);
            $action = new CreateArquivoAction;
            $action->from_uploaded_file(
                $pedidoDocumento,
                $validated['arquivo']
            );
            $notify = new NovoDocumentoAction;
            $notify($pedidoDocumento);
            return true;
        });
        if ($request->wantsJson()) {
            if ($success) {
                return response()->json(['message' => 'Arquivo enviado com sucesso!']);
            }
            return response()->json(['message' => 'Falha ao enviar o arquivo!'], 422);
        }
        if ($success) {
            session()->flash('success', 'Arquivo enviado com sucesso!');
            return back()->with('success', 'Arquivo enviado com sucesso!');
        }
        session()->flash('error', 'Arquivo enviado com sucesso!');
        return back()->with('error', 'Arquivo enviado com sucesso!');
    }
}
