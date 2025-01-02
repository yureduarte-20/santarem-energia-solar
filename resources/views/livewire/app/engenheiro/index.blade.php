<div>
    <section class="my-2">
        <div class="mb-1">
            <x-input label="Pesquisa" aria-autocomplete="false" autocomplete="false" wire:model.live.debounce='query' />
        </div>
        @can('create-engenheiros')
            <x-button label="Criar" icon="plus" color="primary" x-on:click="$wire.$set('createModal', true)" />
        @endcan
    </section>
    <x-table.data-table>
        <x-slot name="headerColumns">
            <x-table.header-column>Nome</x-table.header-column>
            <x-table.header-column>Cpf</x-table.header-column>
            <x-table.header-column></x-table.header-column>
        </x-slot>
        <x-slot name="dataRows">
            @forelse ($engs as $eng)
                <x-table.data-row wire:key='engenheiro_{{ $eng->id }}'>
                    <x-table.data-column>
                        {{ $eng->conta->user->name }}
                    </x-table.data-column>
                    <x-table.data-column>
                        {{ $eng->cpf }}
                    </x-table.data-column>
                    <x-table.data-column>
                        @can('edit-engenheiros')
                            <x-button icon="pencil" color="primary" wire:click="editModal('{{ $eng->id }}')" />
                        @endcan
                        @can('delete-engenheiros')
                            <x-button class="ml-2" icon="trash"
                                x-on:click="$wireui.confirmDialog({
                                title:'Tem certeza que deseja exluir essse engeneiro?',
                                method:'delete',
                                params: '{{ $eng->id }}'
                                }, '{{ $componentId }}')"
                                color="negative" />
                        @endcan
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
                <x-input label="Nome" wire:model='formCreate.name' />
            </div>
            <div>
                <x-inputs.maskable mask="###.###.###-##" label="CPF" wire:model='formCreate.cpf' />
            </div>
            <div>
                <x-input label="Email" type="email" wire:model='formCreate.email' />
            </div>
            <div>
                <x-input label="Senha" type="password" wire:model='formCreate.password' />
            </div>
        </div>
        <x-slot name="footer">
            @can('create-engenheiros')
                <x-button label="Criar" color="primary" wire:click='create' />
            @endcan
            <x-button label="Cancelar" x-on:click="close" />
        </x-slot>
    </x-modal.card>
    <x-modal.card wire:model.defer='updateModal' title="Atualizar dados do engenheiro">
        <div class="grid lg:grid-rows-2 grid-rows-1 gap-2">
            <div>
                <x-input label="Nome" wire:model='formUpdate.name' />
            </div>
            <div>
                <x-inputs.maskable mask="###.###.###-##" label="CPF" wire:model='formUpdate.cpf' />
            </div>
            <div>
                <x-input type="email" label="Email" wire:model='formUpdate.email' />
            </div>
        </div>
        <x-slot name="footer">
            @can('edit-engenheiros')
                <x-button label="Atualizar" color="primary" wire:click='edit' />
            @endcan
            <x-button label="Cancelar" x-on:click="close" />
        </x-slot>
    </x-modal.card>
</div>
