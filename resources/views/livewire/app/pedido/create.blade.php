<div>
    <div class="grid lg:grid-cols-3 grid-cols-1 gap-2">
        <div>
            <x-input label="Número do Pedido" wire:model='numero' />
        </div>
        <div>
            <x-select label="Cliente" :async-data="route('cliente.search', ['pre_fetch' => $cliente_id])" wire:model='cliente_id' option-value="id" option-label="nome" />
        </div>
        <div>
            <x-input label="Data do Pedido" wire:model='data_pedido' type="date" />
        </div>
        <div>
            <x-input label="Previsão de Entrega" wire:model='data_previsao' type="date" />
        </div>
        <div>
            <x-native-select label="Vendedor" wire:model='user_id'>
                @foreach (\App\Models\User::all() as $user)
                    <option @if (Auth::user()->id == $user->id) selected @endif value="{{ $user->id }}">
                        {{ $user->name }}</option>
                @endforeach
            </x-native-select>
        </div>
        <x-select label="Homologação do Engenheiro">
            @foreach ($engenheiros as $eng)
                <x-select.option label="{{ $eng->nome }}" value="{{ $eng->id }}" />
            @endforeach
        </x-select>

        <div>
            <x-inputs.currency label="Valor contratual" icon="currency-dollar" thousands="." decimal=","
                wire:model='valor_contratual' precision="2" />
        </div>
        <div>
            <x-inputs.currency label="Valor" icon="currency-dollar" thousands="." decimal="," precision="2"
                wire:model='valor' />
        </div>
        <div>
            <x-select multiselect :options="$documentos_disp" wire:model='documentos' option-value="id"
                label="Documentos Obrigatórios" option-label="nome" />
        </div>
        <div>
            <x-input 
            type="number" min="0"
            label="Quantidade KIT Contratado" wire:model='qtde_contratado' />
        </div>
        <div>
            <x-input 
            min="0" label="Quantidade KIT Entregue" wire:model='qtde_entregue' />
        </div>
        <div>
            <x-native-select label="AUMENTO DE CARGA 220 DA PRINCIPAL" >
                <option value>Selecione </option>
                @foreach ( \App\Enums\TipoRede::cases() as $tipo)
                    <option value="{{$tipo->name}}" >{{$tipo->label()}}</option>    
                @endforeach
                
            </x-native-select>
        </div>
    </div>
</div>
