<div>
    @if ($pedido->relogio_bidirecional()->doesntExist())
        <h2>Situação do relógio Bidirecional não cadastrada</h2>
        <div class="grid mb-2 lg:grid-cols-4 grid-cols-1 gap-2 ">
            <x-input label="Data da Solicitação"
            type="date"
            wire:model='createForm.data_solicitacao' />
        </div>
        @can('edit-pedidos')
            <x-button label="salvar" primary wire:click='create' />
        @endcan
    @else
        <h2>Relógio Bidirecional </h2>
        <div class="grid mb-2 lg:grid-cols-2 grid-cols-1 gap-2 " x-data="{status: $wire.$entangle('updateForm.status')}">
            <x-input label="Data da Solicitação" wire:model='updateForm.data_solicitacao' type="date" />
            <x-input label="Data da resposta" wire:model='updateForm.data_retorno' type="date" />
            <x-native-select x-model="status" label="Status" wire:model='updateForm.status'>
                @foreach (\App\Enums\StatusRelogioBidirecional::cases() as $status)
                    <option value="{{$status->name}}">{{$status->label()}}</option>
                @endforeach
            </x-native-select>
            <div x-show="status == '{{\App\Enums\StatusRelogioBidirecional::NEGADO->name}}'" class="lg:col-span-2">
                <x-textarea label="Motivo" wire:model='updateForm.observacoes' />
            </div>
        </div>
        @can('edit-pedidos')
            <x-button label="salvar" primary wire:click='update' />
        @endcan
    @endif
</div>
