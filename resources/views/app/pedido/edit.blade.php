<x-app-layout>
    <x-general.dashboard>
        <x-errors />
        @can('show-clientes')
        <div class="mb-2">
            <h2>Clientes</h2>
            <livewire:app.cliente.edit :cliente="$pedido->cliente" />
                <hr class="mt-2" />
        </div>
        @endcan
        @can('show-pedidos')
        <div class="mb-2">
            <h2>Pedido</h2>
            <livewire:app.pedido.edit :pedido="$pedido" />
        </div>
        @endcan
        <div>
            @can('view-docs')
                <livewire:app.pedido.documento :pedido="$pedido" />
            @endcan
        </div>
    </x-general.dashboard>
</x-app-layout>
