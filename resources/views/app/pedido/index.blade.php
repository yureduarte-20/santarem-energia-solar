<x-app-layout>
    <x-general.dashboard title="{{__('Orders')}}">
        <x-table.data-table>
            <x-slot name="headerColumns">
                <x-table.header-column>Nome</x-table.header-column>
                <x-table.header-column>Engenheiro</x-table.header-column>
                <x-table.header-column>Data do pedido</x-table.header-column>
                <x-table.header-column>Previsão de Entrega</x-table.header-column>
                <x-table.header-column>Valor Projeto Final</x-table.header-column>
                <x-table.header-column>Valor do KIT</x-table.header-column>
                <x-table.header-column></x-table.header-column>
            </x-slot>
            <x-slot name="dataRows">
                @foreach($pedidos as $p)
                    <x-table.data-row>
                        <x-table.data-column>
                            <div class="flex flex-col">
                                @if($p->pedido_documentos()->where('entregue', false)->exists())
                                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">Documentação pendente</span>
                                @endif
                                <span>{{$p->cliente->nome}}</span>
                            </div>
                        </x-table.data-column>
                        <x-table.data-column>{{$p->homologacao_engenheiros?->map?->nome->whenEmpty(fn () => collect('Não informado'))->join(',', ' e ') }}</x-table.data-column>
                        <x-table.data-column>{{$p->data_pedido->format('d/m/Y')}}</x-table.data-column>
                        <x-table.data-column>{{$p->previsao_entrega->format('d/m/Y')}}</x-table.data-column>
                        <x-table.data-column>
                            R$ {{number_format($p->valor_contratual, 2, ',','.')}}</x-table.data-column>
                        <x-table.data-column>R$ {{number_format($p->valor, 2, ',','.')}}</x-table.data-column>
                        <x-table.data-column>
                            <x-button icon="pencil" :href="route('pedido.edit', $p)" color="primary"/>
                        </x-table.data-column>
                    </x-table.data-row>
                @endforeach
            </x-slot>
            <x-slot name="footer">
                {{$pedidos->links()}}
            </x-slot>
        </x-table.data-table>
    </x-general.dashboard>
</x-app-layout>
