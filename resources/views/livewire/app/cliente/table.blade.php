<div>
    <section class="mb-2">
        <div class="mb-2">
            <x-input wire:model.live.debounce="query" icon="search" label="Pesquisar" />
        </div>
        @can('create-clientes')
        <x-button color="primary" x-on:click="Livewire.navigate('{{ route('cliente.create') }}')" label="Criar" />
        @endcan
    </section>

    <x-table.data-table>
        <x-slot name="headerColumns">
            <x-table.header-column>Nome</x-table.header-column>
            <x-table.header-column>Cpf</x-table.header-column>
            <x-table.header-column></x-table.header-column>
        </x-slot>
        <x-slot name="dataRows">
            @forelse($clientes as $eng)
                <x-table.data-row>
                    <x-table.data-column>
                        {{ $eng->nome }}
                    </x-table.data-column>
                    <x-table.data-column>
                        {{ $eng->cpf }}
                    </x-table.data-column>
                    <x-table.data-column>
                        @can('show-pedidos')
                            @if($eng->pedidos()->latest()->first())
                                <x-button href="{{route('pedido.edit', $eng->pedidos()->latest()->first() )}}" label="Pedido" color="primary" />
                            @endif
                        @endcan
                        @can('edit-clientes')
                            <x-button color="secondary" icon="pencil" x-on:click="Livewire.navigate('{{route('cliente.edit', $eng)}}')" />
                        @endcan
                    </x-table.data-column>
                </x-table.data-row>
                @empty
                <x-table.data-row>
                    <x-table.data-column>
                        Sem Clientes cadastrados
                    </x-table.data-column>
                    <x-table.data-column>
                        
                    </x-table.data-column>
                    <x-table.data-column>
                        
                    </x-table.data-column>
                </x-table.data-row>
            @endforelse
        </x-slot>
        <x-slot name="footer">
            {{ $clientes->links() }}
        </x-slot>
    </x-table.data-table>
</div>
