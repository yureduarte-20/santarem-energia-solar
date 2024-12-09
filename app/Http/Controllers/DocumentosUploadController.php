<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDocumento;
use CreateArquivoAction;
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

    }
}