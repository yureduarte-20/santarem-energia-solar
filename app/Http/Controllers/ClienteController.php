<?php

namespace App\Http\Controllers;

use App\Actions\App\Cliente\GetCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->query('search');
        $pre_fetch = $request->query('pre_fetch');
        $pre_fetch = is_array($pre_fetch) ? $pre_fetch : [$pre_fetch];
        
        $results = (new GetCliente())->query()->when($search, fn($q2) => $q2->whereRaw('LOWER (clientes.nome) LIKE LOWER(?)', [$search . '%'])
            ->orWhere('cpf', 'LIKE', $search . '%'))
            ->when($pre_fetch, fn($q) => $q->orWhereIn('id', $pre_fetch))
            ->limit(30)
            ->get(['nome', 'id']);
        return response()->json($results);
    }
    public function edit(Cliente $cliente)
    {
        return view('app.cliente.edit', compact('cliente'));
    }
}
