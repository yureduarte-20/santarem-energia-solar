<div>
    <form wire:submit='submit'>
        <div class="grid mb-2 lg:grid-cols-3 grid-cols-1 lg:gap-2 gap-1">
            <div>
                <x-input label="Nome" wire:model='form.nome' />
            </div>
            <div>
                <x-inputs.maskable mask="###.###.###-##" label="CPF" wire:model='form.cpf' />
            </div>
            <div>
                <x-inputs.maskable mask="(##) #####-####" label="telefone" wire:model='form.telefone' />
            </div>
            <div>
                <x-input label="Email" type="email" wire:model='form.email' />
            </div>
        </div>
        <hr />
        <h2>Endereço</h2>
        <div class="grid mb-2 lg:grid-cols-2 grid-cols-1 lg:gap-2 gap-1" wire:target='updatedForm' wire:loading.remove>
            <div>
                <x-input label="Cep" wire:model.blur='form.endereco.cep' />
            </div>
            <div>
                <x-input wire:loading.attr='disable' label="rua" wire:model='form.endereco.rua' />
            </div>
            <div>
                <x-input label="Número" wire:loading.attr='disable' wire:model='form.endereco.numero' />
            </div>
            <div>
                <x-input label="Bairro" wire:loading.attr='disable' wire:model='form.endereco.bairro' />
            </div>
            <div>
                <x-input label="Cidade" wire:loading.attr='disable' wire:model='form.endereco.cidade' />
            </div>
            <div>
                <x-input label="UF" wire:loading.attr='disable' wire:model='form.endereco.uf' />
            </div>
            <div>
                <x-native-select label="Tipo de Telhado" wire:model='form.endereco.tipo_telhado'>
                    <option value>Selecione um tipo de telhado</option>
                    @foreach (\App\Enums\TipoTelhado::cases() as $tipo)
                        <option value="{{$tipo->name}}">{{$tipo->label()}}</option>
                    @endforeach
                </x-native-select>
            </div>
        </div>
        <div wire:loading wire:target='updatedForm' class="flex w-full mx-auto justify-center items-center">
            <div class="animate-spin inline-block size-8 border-[3px] border-current border-t-transparent text-primary-600 rounded-full dark:text-primary-500"
                role="status" aria-label="loading">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div>
            @can('edit-clientes')
                <x-button label="Salvar" type="submit" color="primary" />
            @endcan
        </div>
    </form>
</div>
