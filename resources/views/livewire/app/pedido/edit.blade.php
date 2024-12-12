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
                    x-on:confirm="{
                        id:'encerrar',
                        'title':'Deseja declarar com entregue ao engenheiro?',
                        description:'Deseja declarar que o projeto foi encaminhado ao engenheiro?',
                        method:'updateStatus',
                        params:'{{\App\Enums\StatusPedido::ENVIADO_ENGENHEIRO->name}}'
                    }"
                    label="Declarar que enviou para engenherio" />
                @break
                @case(\App\Enums\StatusPedido::ENVIADO_ENGENHEIRO)
                    <x-button label="Finalizar o projeto" 
                    color="primary"
                    x-on:confirm="{
                        id:'encerrar',
                        'title':'Deseja declarar com entregue?',
                        description:'Deseja declarar como projeto finalizado?',
                        method:'updateStatus',
                        params:'{{\App\Enums\StatusPedido::FINALIZADO->name}}'
                    }"
                
                    />
                @break
            
                @default
                    
            @endswitch
        </div>
        <div class="lg:col-span-3">
            <x-textarea label="Observações" wire:model='descricao'></x-textarea>
        </div>
        <div class="lg:col-span-3">
            <h3>Rateios</h3>
            <x-button icon="plus" color="primary" label="Adicionar Pessoa Vinculada ao rateio" wire:click='addRateio' />
            @if ($rateios)
                @foreach ($rateios as $key => $rat)
                    <div  wire:key="rateio_{{ $rat['nome'] }}" class="w-full mt-2 flex lg:flex-row flex-col gap-1 items-center">
                        <div class="w-full">
                            <x-input label="Nome"  wire:model="rateios.{{ $key }}.nome" />
                        </div>
                        <div class="lg:mt-5 mt-1 w-full lg:w-max">
                            <x-button icon="trash" class="w-full lg:w-max" color="negative"
                                wire:click="removeRateio('{{ $key }}')" />
                        </div>
                    </div>
                @endforeach
                @else
                <p class="text-gray-500">Sem pessoas vinculadas ao rateio</p>
            @endif
            <hr class="mt-3" />
        </div>
    </div>
    <div class="mt-2">
        <x-button label="Salvar" wire:click="save" color="primary" icon="save"/>
    </div>

    <x-dialog id="encerrar">
        <x-input type="date" label="Data de Entrega" wire:model='data_entrega' />
    </x-dialog>
</div>
