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
            <x-input label="Previsão de Entrega" wire:model='previsao_entrega' type="date" />
        </div>
        <div>
            <x-native-select label="Vendedor" wire:model='user_id'>
                <option value>Selecione um vendedor</option>
                @foreach (\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}</option>
                @endforeach
            </x-native-select>
        </div>
        <x-select label="Homologação do Engenheiro" wire:model='engenheiros_homologacao'>
            @foreach ($engenheiros as $eng)
                <x-select.option label="{{ $eng->nome }}" value="{{ $eng->id }}" />
            @endforeach
        </x-select>

        <div>
            <x-inputs.currency label="VALOR DO PROJETO FINAL" icon="currency-dollar" thousands="." decimal=","
                wire:model='valor_contratual' precision="2" />
        </div>
        <div>
            <x-inputs.currency label="VALOR DO KIT" icon="currency-dollar" thousands="." decimal="," precision="2"
                wire:model='valor' />
        </div>
        <div x-data="{
            createTipoDocumento(nome){
                if(nome){
                    axios.post(`{{route('tipo-documento.store')}}`, {nome})
                    .then(d => $wireui.notify({
                        title:'Cadastrado com sucesso!',
                        icon:'success'
                    }))
                    .catch(e => $wireui.notify({
                        title:'Falha ao tentar cadastrar',
                        description: e.response?.data?.message,
                        icon:'error'
                    }))
                    .finally(() => $wire.$refresh())
                }
            }
        }">
            <x-select multiselect :async-data="route('tipo-documento.search')" wire:model='documentos' option-value="id"
                label="Documentos Obrigatórios" option-label="nome" >
                
                <x-slot name="afterOptions" class="p-2 flex justify-center" x-show="displayOptions.length === 0">
                    <x-button
                        x-on:click="createTipoDocumento(search)"
                        primary
                        flat
                        full>
                        <span x-html="`Criar <b>${search}</b>`"></span>
                    </x-button>
                </x-slot>
                </x-select>
        </div>
        <div>
            <x-input
            type="number" min="0"
            label="QTD MODULOS NO CONTRATO" wire:model='qtde_contratado' />
        </div>
        <div>
            <x-input
            min="0" label="QTD MODULOS NO PEDIDO" wire:model='qtde_pedido' />
        </div>
        <div>
            <x-native-select label="AUMENTO DE CARGA 220 DA PRINCIPAL" wire:model="tipo_rede" >
                <option value>Selecione </option>
                @foreach ( \App\Enums\TipoRede::cases() as $tipo)
                    <option value="{{$tipo->name}}" >{{$tipo->label()}}</option>
                @endforeach

            </x-native-select>
        </div>
    </div>
    <div class="mt-2">
        <x-button label="Salvar" wire:click="create" color="primary" icon="save" />
    </div>

</div>
