<div class="" x-on:pedido-updated.window="$wire.$refresh()">
    <x-table.data-table>
        <x-slot name="headerColumns">
            <x-table.header-column>Tipo de Documento</x-table.header-column>
            <x-table.header-column>Arquivo</x-table.header-column>
            <x-table.header-column>Anexou</x-table.header-column>
            <x-table.header-column>
                <x-button icon="plus" color="primary" x-on:click="$wire.$set('modalDocumento', true)" />
            </x-table.header-column>
        </x-slot>
        <x-slot name="dataRows">
            @foreach ($documentos as $doc)
            <x-table.data-row>
                <x-table.data-column>
                    {{ $doc->tipo_documento->nome }}
                </x-table.data-column>
                <x-table.data-column>
                    {{ $doc->arquivo?->nome ?? '-' }}
                </x-table.data-column>
                <x-table.data-column>
                    {{ $doc->user->name }} - {{ $doc->user->conta->tipo->label() }}
                </x-table.data-column>
                <x-table.data-column wire:key="doc_{{ $doc->id }}">
                    @if ($doc->arquivo()->doesntExist())
                    @can('create-docs')
                    <x-button label="upload" icon="upload" color="primary"
                        x-on:click="$wire.$set('modalUpload', {{ $doc->id }})" />
                    @endcan
                    @else
                    @can('show-docs')
                    <x-button icon="download" color="primary" wire:click="download({{ $doc->id }})" />
                    @endcan
                    @endif
                    @can('edit-docs')
                    <div class="ml-2">
                        @if ($doc->user_id == auth()->user()->id)
                        <x-toggle wire:model='docs.{{ $doc->id }}.enviar_homologacao'
                            x-on:click="$wire.$call('edit',  '{{ $doc->id }}')" label="Visível para o engenheiro" />
                        @endif
                    </div>
                    @endcan
                </x-table.data-column>
            </x-table.data-row>
            @endforeach
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-table.data-table>
    <x-modal.card title="Enviar Documento" wire:model="modalUpload">
        @if ($modalUpload)
        <form action="{{ route('documento.store', $modalUpload) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <x-input type="file" name="arquivo" />
            </div>
            <div class="mt-2">
                <x-button type="submit" label="Enviar" />
                <x-button x-on:click="close" label="Cancelar" />
            </div>
        </form>
        @else
        <x-slot name="footer">
            <x-button x-on:click="close" label="Cancelar" />
        </x-slot>
        @endif
    </x-modal.card>
    <form enctype="multipart/form-data" method="POST" action="{{route('documento.store-pedido', $pedido)}}">
        @csrf
        <x-modal.card wire:model='modalDocumento' title="Adicionar Documento">
            <div x-data="{
                tipoDocumento: null,
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
                <x-input label="Anexe o arquivo" name="arquivo" type="file" />
                
                <x-select :async-data="route('tipo-documento.search')" x-model.defer="tipoDocumento" label="Tipo de Documento"
                    option-value="id" option-label="nome" name="tipo_documento_id" >
                    <x-slot name="afterOptions" class="p-2 flex justify-center" x-show="displayOptions.length === 0">
                        <x-button x-on:click="createTipoDocumento(search)" primary flat full>
                            <span x-html="`Criar <b>${search}</b>`"></span>
                        </x-button>
                    </x-slot>
                </x-select>
                @can('edit-docs')
                <div class="mt-2">
                    <x-toggle name="enviar_homologacao" label="Visível para o engenheiro" />
                </div>
                @endcan
            </div>
            <x-slot name="footer">
                <x-button color="primary" label="Adicionar" type="submit" />
                <x-button label="Cancelar" x-on:click="close" />
            </x-slot>
        </x-modal.card>
    </form>
</div>