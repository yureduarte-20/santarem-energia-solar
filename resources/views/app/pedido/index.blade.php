<x-app-layout>
    <x-general.dashboard title="{{__('Orders')}}">
        <section class="mb-2">
            <x-button 
            icon="plus"
            color="primary"
            label="Criar" x-on:click="Livewire.navigate('{{route('pedido.create')}}')" />
        </section>
        <x-table.data-table>
            <x-slot name="headerColumns">
                <x-table.header-column>Nome</x-table.header-column>
                <x-table.header-column>Engenheiro</x-table.header-column>
                <x-table.header-column>Cidade</x-table.header-column>
                <x-table.header-column>Previsão de Entrega</x-table.header-column>
                <x-table.header-column>Valor Projeto Final</x-table.header-column>
                <x-table.header-column>Valor do KIT</x-table.header-column>
                <x-table.header-column>Tipo de Rede</x-table.header-column>
                <x-table.header-column></x-table.header-column>
            </x-slot>
            <x-slot name="dataRows">
                @forelse($pedidos as $p)
                    <x-table.data-row>
                        <x-table.data-column>
                            <div class="flex flex-col gap-1">
                                @if($p->pedido_documentos()->where('entregue', false)->exists())
                                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">Documentação pendente</span>
                                @endif
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-500 text-white">
                                    {{$p->status->label()}}
                                </span>

                                <span>N°: {{$p->numero}}</span>
                                <span>{{$p->cliente->nome}}</span>
                            </div>
                        </x-table.data-column>
                        <x-table.data-column>{{$p->homologacao_engenheiros?->map?->nome->whenEmpty(fn () => collect('Não informado'))->join(',', ' e ') }}</x-table.data-column>
                        <x-table.data-column>{{$p->cliente->endereco->cidade}}</x-table.data-column>
                        <x-table.data-column>{{$p->previsao_entrega->format('d/m/Y')}}</x-table.data-column>
                        <x-table.data-column>
                            R$ {{number_format($p->valor_contratual, 2, ',','.')}}</x-table.data-column>
                        <x-table.data-column>R$ {{number_format($p->valor, 2, ',','.')}}</x-table.data-column>
                        <x-table.data-column>
                            <x-tipo-rede tipoRede="{{$p->tipo_rede->name}}" />
                        </x-table.data-column>
                        <x-table.data-column>
                            <x-button icon="pencil" :href="route('pedido.edit', $p)" color="primary"/>
                        </x-table.data-column>
                    </x-table.data-row>
                    @empty
                    <x-table.data-row>
                        <x-table.data-column>
                            Sem Pedidos
                        </x-table.data-column>
                        <x-table.data-column></x-table.data-column>
                        <x-table.data-column></x-table.data-column>
                        <x-table.data-column></x-table.data-column>
                        <x-table.data-column> </x-table.data-column>
                        <x-table.data-column></x-table.data-column>
                        <x-table.data-column></x-table.data-column>
                    </x-table.data-row>
                @endforelse
            </x-slot>
            <x-slot name="footer">
                {{$pedidos->links()}}
            </x-slot>
        </x-table.data-table>
    </x-general.dashboard>
</x-app-layout>
