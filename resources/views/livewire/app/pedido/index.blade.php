<div>
    <div class="mb-2">
        <x-card>
            <x-slot:action>
                <x-button icon="plus" color="primary" label="Criar"
                    x-on:click="Livewire.navigate('{{ route('pedido.create') }}')" />
            </x-slot:action>
            <section class="grid lg:grid-cols-6 grid-cols-1 gap-1">
                <x-select wire:model.live='status' label="Filtrar por Situação">
                    <x-select.option value="" label="Selecionar uma situação" />
                    @foreach (\App\Enums\StatusPedido::cases() as $case)
                        <x-select.option :label="$case->label()" :value="$case->name" />
                    @endforeach
                </x-select>
                <x-select label="Com pendências?" placeholder="Selecione uma situaçao" wire:model.live='pendencia'>
                    <x-select.option label="Todas" value="" />
                    <x-select.option label="Com pendências" value="sim" />
                    <x-select.option label="Sem pendências" value="nao" />
                </x-select>
                <div class="mt-2">
                    <x-checkbox label="Documentação pendente?" placeholder="Selecione uma situaçao"
                        wire:model.live='documentacao' />
                </div>

            </section>
        </x-card>
    </div>
    <div wire:loading.class.remove='hidden' wire:loading.class='flex' class="hidden my-3 justify-center items-center">
        <div class="animate-spin inline-block size-8 border-[3px] border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500"
            role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div wire:loading.class='hidden'>
        <x-table.data-table>
            <x-slot name="headerColumns">
                <x-table.header-column>Nome</x-table.header-column>
                <x-table.header-column>Engenheiro</x-table.header-column>
                <x-table.header-column>Cidade</x-table.header-column>
                <x-table.header-column>Previsão de Entrega</x-table.header-column>
                @can('show-valores')
                    <x-table.header-column>Valor Projeto Final</x-table.header-column>
                    <x-table.header-column>Valor do KIT</x-table.header-column>
                @endcan
                <x-table.header-column>Tipo de Rede</x-table.header-column>
                <x-table.header-column></x-table.header-column>
            </x-slot>
            <x-slot name="dataRows">
                @forelse($pedidos as $p)
                    <x-table.data-row>
                        <x-table.data-column>
                            <div class="flex flex-col gap-1">
                                @if ($p->pedido_documentos()->where('entregue', false)->exists())
                                    <span
                                        class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">Documentação
                                        pendente</span>
                                @endif
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-500 text-white">
                                    {{ $p->status->label() }}
                                </span>

                                <span>N°: {{ $p->numero }}</span>
                                <span>{{ $p->cliente->nome }}</span>
                            </div>
                        </x-table.data-column>
                        <x-table.data-column>{{ $p->homologacao_engenheiros?->map?->nome->whenEmpty(fn() => collect('Não informado'))->join(',', ' e ') }}</x-table.data-column>
                        <x-table.data-column>{{ $p->cliente->endereco->cidade }}</x-table.data-column>
                        <x-table.data-column>{{ $p->previsao_entrega->format('d/m/Y') }}</x-table.data-column>
                        @can('show-valores')
                            <x-table.data-column>R$
                                {{ number_format($p->valor_contratual, 2, ',', '.') }}</x-table.data-column>
                            <x-table.data-column>R$ {{ number_format($p->valor, 2, ',', '.') }}</x-table.data-column>
                        @endcan
                        <x-table.data-column>
                            <x-tipo-rede tipoRede="{{ $p->tipo_rede?->name ?? 'Não especificado' }}" />
                        </x-table.data-column>
                        <x-table.data-column>
                            <x-button icon="pencil" :href="route('pedido.edit', $p)" color="primary" />
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
                {{ $pedidos->links() }}
            </x-slot>
        </x-table.data-table>
    </div>
</div>
