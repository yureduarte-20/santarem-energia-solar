<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDocumento;
use App\Actions\App\Arquivo\CreateArquivoAction;
use Illuminate\Http\Request;

class DocumentosUploadController
{
    public function store(Request $request, PedidoDocumento $pedidoDocumento)
    {
        $validated = $request->validate([
            'arquivo' => 'required|file|mimes:png,jpg,docx,pdf,doc'
        ]);
        $request->file();
        $action  = new CreateArquivoAction;

        $action->from_uploaded_file(
            $pedidoDocumento,
            $validated['arquivo']
        );

        if($request->wantsJson()){
            return response()->json([ 'message' => 'Arquivo enviado com sucesso!' ]);
        }
        session()->flash('success', 'Arquivo enviado com sucesso!');
        return back()->with('success', 'Arquivo enviado com sucesso!');
    }
}
