<div>
    <div class="grid lg:grid-cols-3 grid-cols-1 gap-2">
        <div>
            <x-input label="Número do Pedido" wire:model='numero'/>
        </div>
        <div>
            <x-select label="Cliente" :async-data="route('cliente.search', ['pre_fetch' => $cliente_id])"
                      wire:model='cliente_id' option-value="id" option-label="nome"/>
        </div>
        <div>
            <x-input label="Data do Pedido" wire:model='data_pedido' type="date"/>
        </div>
        <div>
            <x-input label="Previsão de Entrega" wire:model='previsao_entrega' type="date"/>
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
        <x-select
        :options="$engenheiros"
        option-label="nome"
        option-value="id"
        label="Homologação do Engenheiro" wire:model='engenheiros_homologacao'>
           
        </x-select>

        <div>
            <x-inputs.currency label="VALOR DO PROJETO FINAL" icon="currency-dollar" thousands="." decimal=","
                               wire:model='valor_contratual' precision="2"/>
        </div>
        <div>
            <x-inputs.currency label="VALOR DO KIT" icon="currency-dollar" thousands="." decimal="," precision="2"
                               wire:model='valor'/>
        </div>

        <div>
            <x-input
                type="number" min="0"
                label="QTD MODULOS NO CONTRATO" wire:model='qtde_contratado'/>
        </div>
        <div>
            <x-input
                min="0" label="QTD MODULOS NO PEDIDO" wire:model='qtde_pedido'/>
        </div>
        <div>
            <x-native-select label="AUMENTO DE CARGA 220 DA PRINCIPAL" wire:model="tipo_rede">
                <option value>Selecione</option>
                @foreach ( \App\Enums\TipoRede::cases() as $tipo)
                    <option value="{{$tipo->name}}">{{$tipo->label()}}</option>
                @endforeach

            </x-native-select>
        </div>
        <div class="pt-5">
            @switch($pedido->status)
                @case(\App\Enums\StatusPedido::ENVIAR_ENGENHEIRO)
                    <x-button color="primary"
                    wire:click="updateStatus('{{\App\Enums\StatusPedido::ENVIADO_ENGENHEIRO->name}}')"
                    label="Enviar para engenherio" />
                @break
                @case(\App\Enums\StatusPedido::ENVIADO_ENGENHEIRO)
                    <x-button label="Finalizar o projeto" 
                    color="primary"
                    x-on:confirm="{
                        id:'encerrar',
                        'title':'Deseja declarar com entregue?',
                        method:'updateStatus',
                        params:'{{\App\Enums\StatusPedido::FINALIZADO->name}}'
                    }"
                
                    />
                @break
            
                @default
                    
            @endswitch
        </div>
    </div>
    <div class="mt-2">
        <x-button label="Salvar" wire:click="save" color="primary" icon="save"/>
    </div>

    <x-dialog id="encerrar">
        <x-input type="date" label="Data de Entrega" wire:model='data_entrega' />
    </x-dialog>
</div>
