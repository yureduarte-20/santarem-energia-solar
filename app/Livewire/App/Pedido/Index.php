<?php

namespace App\Livewire\App\Pedido;

use App\Actions\App\Pedido\GetPedidos;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    #[Url(except: '', nullable: true)]
    public $status;
    #[Url(except: '', nullable: true)]
    public $pendencia;
    #[Url(except: '', nullable: true)]
    public $documentacao;
    public function render()
    {
        return view('livewire.app.pedido.index', [
            'pedidos' =>
                (new GetPedidos)->query()
                    ->when($this->status, fn($q) => $q->where('status', $this->status))
                    ->when($this->pendencia == 'nao', fn($q) => $q->whereDoesntHave(
                        'pendencias',
                        fn($q2) => $q2->where('atendida', false)
                    ))
                    ->when($this->pendencia == 'sim', fn($q) => $q->whereHas(
                        'pendencias',
                        fn($q2) => $q2->where('atendida', false)
                    ))
                    ->when(
                        $this->documentacao,
                        fn($q) => $q->whereHas(
                            'pedido_documentos',
                            fn($q3) => $q3->whereDoesntHave('arquivo')
                        )
                    )
                    ->paginate(10)
        ]);
    }
}
