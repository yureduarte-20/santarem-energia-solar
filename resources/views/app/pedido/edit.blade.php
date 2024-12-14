<x-app-layout>
    <x-general.dashboard>
        <div class="mb-2">
            <livewire:app.pedido.edit :pedido="$pedido" />
        </div>
        <div>
            <livewire:app.pedido.documento :pedido="$pedido" />
        </div>
    </x-general.dashboard>
</x-app-layout>
