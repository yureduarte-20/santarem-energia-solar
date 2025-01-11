<div>
    <x-errors />
    @if (!$pedido->instalacao()->exists())
        <h3 class="text-lg">Cadastramento de Previsão de Instalação</h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 mb-2">
            <x-input label="Data de Previsão de Instalação" type="date" wire:model='createForm.data_prevista' />
        </div>
        @can('edit-pedidos')
            <x-button color="primary" label="Salvar" wire:click='create' />
        @endcan
        @else
        <h3 class="text-lg">Informações da Instalação</h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 mb-2">
            <x-input label="Data de Previsão de Instalação" type="date" wire:model='updateForm.data_prevista' />
            <x-input label="Data da Instalação" type="date" wire:model='updateForm.data_instalada' />
            <div class="lg:col-span-3">
                <x-textarea label="Observações" wire:model='updateForm.observacao' />
            </div>
        </div>
        @can('edit-pedidos')
        <x-button label="Salvar" color="primary" wire:click='update' />
        @endcan

    @endif
</div>
