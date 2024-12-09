<div class="">
    <x-table.data-table>
        <x-slot name="headerColumns">
            <x-table.header-column>Tipo de Documento</x-table.header-column>
            <x-table.header-column>Arquivo</x-table.header-column>
            <x-table.header-column>
                <x-button icon="plus" color="primary"
                x-on:confirm="{
                    id: 'doialog-add',
                    onClose:{
                    method: 'addDocumento',
                    label:'ok'
                    }
                }"
                />
            </x-table.header-column>
        </x-slot>
        <x-slot name="dataRows">
            @foreach($pedido->pedido_documentos as $docs)
                <x-table.data-row>
                    <x-table.data-column>
                        {{$docs->tipo_documento->nome}}
                    </x-table.data-column>
                    <x-table.data-column>
                        {{$docs->arquivo?->nome ?? '-'}}
                    </x-table.data-column>
                    <x-table.data-column>
                        @if($docs->arquivo()->doesntExist())
                        <x-button label="upload" icon="upload" color="primary"
                                  x-on:click="$wire.$set('modalUpload', {{$docs->id}})"
                        />
                        @else
                            <x-button icon="download" color="primary"
                                      wire:click="download({{$docs->id}})"
                            />
                        @endif

                    </x-table.data-column>
                </x-table.data-row>
            @endforeach
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-table.data-table>
    <x-modal.card title="Enviar Documento" wire:model="modalUpload">
        @if($modalUpload)
            <form action="{{route('documento.store', $modalUpload)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <x-input type="file" name="arquivo"/>
                </div>
                <div class="mt-2">
                    <x-button type="submit" label="Enviar" />
                    <x-button x-on:click="close" label="Cancelar"/>
                </div>
            </form>
        @else
            <x-slot name="footer">
                <x-button x-on:click="close" label="Cancelar"/>
            </x-slot>
        @endif
    </x-modal.card>
    <x-dialog  id="doialog-add" title="Adicionar Documento">
        <x-select
            :options="$tipo_documentos"
            wire:model="tipoDocumento"
                  label="Tipo de Documento"
                  option-value="id" option-label="nome" />
    </x-dialog>
</div>
