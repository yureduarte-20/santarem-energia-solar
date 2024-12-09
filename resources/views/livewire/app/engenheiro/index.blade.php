<div>
    <section class="my-2">
        <div class="mb-1">
            <x-input label="Pesquisa" wire:model.live.debounce='query' />
        </div>
        <x-button label="Criar" icon="plus" color="primary" x-on:click="$wire.$set('createModal', true)" />
    </section>
    <x-table.data-table>
        <x-slot name="headerColumns">
            <x-table.header-column>Nome</x-table.header-column>
            <x-table.header-column>Cpf</x-table.header-column>
        </x-slot>
        <x-slot name="dataRows">
            @foreach ($engs as $eng)
                <x-table.data-row>
                    <x-table.data-column>
                        {{ $eng->nome }}
                    </x-table.data-column>
                    <x-table.data-column>
                        {{ $eng->cpf }}
                    </x-table.data-column>
                </x-table.data-row>
            @endforeach
        </x-slot>
        <x-slot name="footer">
            {{ $engs->links() }}
        </x-slot>
    </x-table.data-table>
    <x-modal.card wire:model.defer='createModal'>
        <div class="grid lg:grid-rows-2 grid-rows-1 gap-2">
            <div>
                <x-input label="Nome" wire:model='formCreate.nome' />
            </div>
            <div>
                <x-inputs.maskable mask="###.###.###-##" label="CPF" wire:model='formCreate.cpf' />
            </div>
        </div>
        <x-slot name="footer" >
            <x-button label="Criar" color="primary" wire:click='create' />
            <x-button label="Cancelar" x-on:click="close" />
        </x-slot>
    </x-modal.card>
</div>
