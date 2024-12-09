<div>
    <section class="mb-2">
        <div class="mb-2">
            <x-input wire:model.live.debounce="query" icon="search" label="Pesquisar" />
        </div>
        <x-button color="primary" x-on:click="Livewire.navigate('{{ route('cliente.create') }}')" label="Criar" />
    </section>

    <x-table.data-table>
        <x-slot name="headerColumns">
            <x-table.header-column>Nome</x-table.header-column>
            <x-table.header-column>Cpf</x-table.header-column>
            <x-table.header-column></x-table.header-column>
        </x-slot>
        <x-slot name="dataRows">
            @foreach ($clientes as $eng)
                <x-table.data-row>
                    <x-table.data-column>
                        {{ $eng->nome }}
                    </x-table.data-column>
                    <x-table.data-column>
                        {{ $eng->cpf }}
                    </x-table.data-column>
                    <x-table.data-column>
                        <x-button color="secondary" icon="pencil" />
                    </x-table.data-column>
                </x-table.data-row>
            @endforeach
        </x-slot>
        <x-slot name="footer">
            {{ $clientes->links() }}
        </x-slot>
    </x-table.data-table>
</div>
