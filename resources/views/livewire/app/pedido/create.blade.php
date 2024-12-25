<div>
    <div class="grid lg:grid-cols-3 grid-cols-1 gap-2">
        <div>
            <x-input label="Número do Pedido" wire:model='form.numero' />
        </div>
        <div>
            <x-select label="Cliente" :async-data="route('cliente.search', ['pre_fetch' => $form->cliente_id])" wire:model='form.cliente_id' option-value="id"
                option-label="nome" />
        </div>
        <div>
            <x-input label="Data do Pedido" wire:model='form.data_pedido' type="date" />
        </div>
        <div>
            <x-input label="Previsão de Entrega" wire:model='form.previsao_entrega' type="date" />
        </div>
        <div>
            <x-native-select label="Vendedor" wire:model='form.user_id'>
                <option value>Selecione um vendedor</option>
                @foreach (\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}</option>
                @endforeach
            </x-native-select>
        </div>
        <x-select label="Homologação do Engenheiro" wire:model='form.engenheiros_homologacao'>
            @foreach ($engenheiros as $eng)
                <x-select.option label="{{ $eng->nome }}" value="{{ $eng->id }}" />
            @endforeach
        </x-select>

        <div>
            <x-inputs.currency label="VALOR DO PROJETO FINAL" icon="currency-dollar" thousands="." decimal=","
                wire:model='form.valor_contratual' precision="2" />
        </div>
        <div>
            <x-inputs.currency label="VALOR DO KIT" icon="currency-dollar" thousands="." decimal="," precision="2"
                wire:model='form.valor' />
        </div>
        <div x-data="{
            createTipoDocumento(nome) {
                if (nome) {
                    axios.post(`{{ route('tipo-documento.store') }}`, { nome })
                        .then(d => $wireui.notify({
                            title: 'Cadastrado com sucesso!',
                            icon: 'success'
                        }))
                        .catch(e => $wireui.notify({
                            title: 'Falha ao tentar cadastrar',
                            description: e.response?.data?.message,
                            icon: 'error'
                        }))
                        .finally(() => $wire.$refresh())
                }
            }
        }">
            <x-select multiselect :async-data="route('tipo-documento.search')" wire:model='form.documentos' option-value="id"
                label="Documentos Obrigatórios" option-label="nome">

                <x-slot name="afterOptions" class="p-2 flex justify-center" x-show="displayOptions.length === 0">
                    <x-button x-on:click="createTipoDocumento(search)" primary flat full>
                        <span x-html="`Criar <b>${search}</b>`"></span>
                    </x-button>
                </x-slot>
            </x-select>
        </div>
        <div>
            <x-input type="number" min="0" label="QTD MODULOS NO CONTRATO" wire:model='form.qtde_contratado' />
        </div>
        <div>
            <x-input min="0" label="QTD MODULOS NO PEDIDO" wire:model='form.qtde_pedido' />
        </div>
        <div>
            <x-native-select label="AUMENTO DE CARGA 220 DA PRINCIPAL" wire:model="form.tipo_rede">
                <option value>Selecione </option>
                @foreach (\App\Enums\TipoRede::cases() as $tipo)
                    <option value="{{ $tipo->name }}">{{ $tipo->label() }}</option>
                @endforeach

            </x-native-select>
        </div>
        <div class="lg:col-span-3">
            <x-textarea label="Observações" wire:model='descricao'></x-textarea>
        </div>
        <div class="lg:col-span-3">
            <h3>Rateios</h3>
            <x-button icon="plus" color="primary" label="Adicionar Pessoa Vinculada ao rateio"
                x-on:click="$wire.$call('addRateio')" />
            @if ($form->rateios)
                @foreach ($form->rateios as $key => $rat)
                    <div wire:key="rateio_{{ $rat['nome'] }}"
                        class="w-full mt-2 flex lg:flex-row flex-col gap-1 items-center">
                        <div class="w-full">
                            <x-input label="Nome" wire:model="form.rateios.{{ $key }}.nome" />
                        </div>
                        <div class="lg:mt-5 mt-1 w-full lg:w-max">
                            <x-button icon="trash" class="w-full lg:w-max" color="negative"
                                x-on:click="$wire.$call('removeRateio', '{{ $key }}')" />
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
        <x-button label="Salvar" wire:click="create" color="primary" icon="save" />
    </div>

</div>
