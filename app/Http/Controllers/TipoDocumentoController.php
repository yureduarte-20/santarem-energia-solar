<?php

namespace App\Http\Controllers;

use App\Actions\App\TipoDocumento\CreateTipoDocumentoAction;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
    public function store(Request $request)
    {
        $action = new CreateTipoDocumentoAction;
        $data = $action(
            $request->all()
        );
        if($request->wantsJson()){
            return response()->json($data);
        }
        return redirect()->back()->with("success","Criado com sucesso!");
    }
    public function search(Request $request)
    {
        $search = $request->query("search");
        $pre_fetch = $request->query("pre_fetch");
        
        $results = TipoDocumento::when($search, fn($q2) => $q2->whereRaw('LOWER(nome) LIKE LOWER(?)', [$search.'%']))
                                ->when($pre_fetch, fn($q1) => $q1->orWhereIn('id', is_array($pre_fetch) ? $pre_fetch : [$pre_fetch]) )
                                ->limit(20)
                                ->get(['id', 'nome']);
        return response()->json($results);
    }
}
