<x-app-layout>
    <x-general.dashboard>
        <div class="mb-2">
            <livewire:app.pedido.edit :pedido="$pedido" />
        </div>
        <div>
            @can('view-docs')
                <livewire:app.pedido.documento :pedido="$pedido" />
            @endcan
        </div>
    </x-general.dashboard>
</x-app-layout>
