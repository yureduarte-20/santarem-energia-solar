<div>
    <section class="mb-2">
        <x-button x-on:click="$wire.$set('modalCreate', true)"
        color="primary"
        label="Cadastrar Novo Usuário" icon="plus" />
    </section>
    <x-table.data-table>
        <x-slot name="headerColumns">
            <x-table.header-column>Nome</x-table.header-column>
            <x-table.header-column>Email</x-table.header-column>
            <x-table.header-column>Papel</x-table.header-column>
            <x-table.header-column></x-table.header-column>
        </x-slot>
        <x-slot name="dataRows">
            @foreach ($users as $user)
                <x-table.data-row>
                    <x-table.data-column>{{ $user->name }}</x-table.data-column>
                    <x-table.data-column>{{ $user->email }}</x-table.data-column>
                    <x-table.data-column>{{ $user->conta->tipo->label() }}</x-table.data-column>
                    <x-table.data-column></x-table.data-column>
                </x-table.data-row>
            @endforeach
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-table.data-table>
    <x-modal.card wire:model='modalCreate' title="Criar um novo usuário">
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
            <x-input label="Nome" wire:model='createForm.name' />
            <x-input label="Email" type="email" wire:model='createForm.email' />
            <x-input label="Senha" wire:model='createForm.password' />
            <x-native-select label="Papel no sistema" wire:model='createForm.tipo' >
                <option valur>Selecione um papel</option>
                <option value="{{App\Enums\TipoConta::ADMIN->name}}">{{\App\Enums\TipoConta::ADMIN->label()}}</option>
                <option value="{{App\Enums\TipoConta::INSTALADOR->name}}">{{\App\Enums\TipoConta::INSTALADOR->label()}}</option>
                <option value="{{App\Enums\TipoConta::VENDEDOR->name}}">{{\App\Enums\TipoConta::VENDEDOR->label()}}</option>
            </x-native-select>

        </div>
        <x-slot name="footer">
            <x-button color="primary" label="Enviar" wire:click='create' />
            <x-button label="Cancelar" x-on:click="close" />
        </x-slot>
    </x-modal.card>
</div>
