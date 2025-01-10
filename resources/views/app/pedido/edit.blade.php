<x-app-layout>
    <x-general.dashboard>
        <div x-data="{
            tab: 'pedido'
        }">
            <x-errors />
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 mb-3">
                <ul class="flex flex-wrap -mb-px">
                    <li class="me-2">
                        <a href="#" x-on:click="tab = 'pedido'"
                            x-bind:class="tab == 'pedido' ?
                                'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500' :
                                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                            aria-current="page">Pedido</a>
                    </li>
                    @can('show-clientes')
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'cliente'"
                                x-bind:class="tab == 'cliente' ?
                                    'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500' :
                                    'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                                aria-current="page">Cliente</a>
                        </li>
                    @endcan
                    <li class="me-2">
                        <a href="#" x-on:click="tab = 'instalacao'"
                            x-bind:class="tab == 'instalacao' ?
                                'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500' :
                                'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                            aria-current="page">Informações da Instalação</a>
                    </li>
                </ul>
            </div>

            <div x-show="tab == 'pedido'">
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
            </div>
            <div x-show="tab == 'cliente'">
                @can('show-clientes')
                    <div class="mb-2">
                        <h2>Clientes</h2>
                        <livewire:app.cliente.edit :cliente="$pedido->cliente" />
                        <hr class="mt-2" />
                    </div>
                @endcan
            </div>
            <div x-show="tab == 'instalacao'">
                <div class="mb-2">
                    <livewire:app.pedido.instalacao :pedido="$pedido" />
                </div>
            </div>
        </div>
    </x-general.dashboard>
</x-app-layout>
