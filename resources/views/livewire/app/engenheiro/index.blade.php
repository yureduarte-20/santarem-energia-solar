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
            <x-table.header-column></x-table.header-column>
        </x-slot>
        <x-slot name="dataRows">
            @forelse ($engs as $eng)
                <x-table.data-row wire:key='engenheiro_{{$eng->id}}'>
                    <x-table.data-column>
                        {{ $eng->nome }}
                    </x-table.data-column>
                    <x-table.data-column>
                        {{ $eng->cpf }}
                    </x-table.data-column>
                    <x-table.data-column>
                        <x-button icon="pencil" color="primary" wire:click="editModal('{{$eng->id}}')" />
                        <x-button class="ml-2" icon="trash"
                            wire:ignore.self
                            color="negative"
                            x-on:confirm="{
                                title:'Tem certeza que deseja deletar este engenheiro?',
                                description:'Essa ação não pode ser desfeita!',
                                method:'delete',
                                params: '{{$eng->id}}'
                            }" />
                    </x-table.data-column>
                </x-table.data-row>
                @empty
                <x-table.data-row>
                    <x-table.data-column>
                        Sem engenheiros cadastrados
                    </x-table.data-column>
                    <x-table.data-column>
                        
                    </x-table.data-column>
                    <x-table.data-column>
                        
                    </x-table.data-column>
                </x-table.data-row>
            @endforelse
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
    <x-modal.card wire:model.defer='updateModal' title="Atualizar dados do engenheiro">
        <div class="grid lg:grid-rows-2 grid-rows-1 gap-2">
            <div>
                <x-input label="Nome" wire:model='formUpdate.nome' />
            </div>
            <div>
                <x-inputs.maskable mask="###.###.###-##" label="CPF" wire:model='formUpdate.cpf' />
            </div>
        </div>
        <x-slot name="footer" >
            <x-button label="Criar" color="primary" wire:click='edit' />
            <x-button label="Cancelar" x-on:click="close" />
        </x-slot>
    </x-modal.card>
</div>
