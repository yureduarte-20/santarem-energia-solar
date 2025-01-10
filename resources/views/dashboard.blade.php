<x-app-layout>
    <x-general.dashboard>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
            @can('show-valores')

                <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                    <x-apex.line
                        title="Faturamento por mês"
                        :series="[
                            ['data' => $faturamento_mes->pluck('total_valor')->toArray(), 'name' => 'Faturamento'],
                            ['data' => $lucro_bruto_mes->pluck('lucro_bruto')->toArray(), 'name' => 'Lucro Bruto']
                        ]"
                        :xaxis="[ 'categories' =>  $faturamento_mes->pluck('mes')->toArray() ]" />
                </div>

            @endcan

            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <x-apex.pie
                    :title="['align' => 'center', 'text' => 'Por Situação']"
                    :series="$dados->map->contagem->toArray()"
                    :labels="$dados->map->status->toArray()"
                    onClickLegend="(chart, seriesIndex, opts) => {
                        const data = {!! json_encode($dados->map->status_value->toArray()) !!} ;
                        let url = `{{route('pedido.index')}}` ;
                        url += '?status=' + data[seriesIndex] ;
                        Livewire.navigate(url)
                    }"
                    />
            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                @if($pendencias->atendidas == 0 and $pendencias->nao_atendidas == 0)
                    <p class="text-center">Sem pendências</p>
                    @else
                    <x-apex.pie
                    :title="['align' => 'center', 'text' => 'Pendências de Engenheiros']"
                    :series="[$pendencias->atendidas, $pendencias->nao_atendidas]"
                    :labels="['Pendentes', 'Resolvidas']"
                    />
                @endif

            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">

                <x-apex.pie
                    :title="['align' => 'center', 'text' => 'Documentação Pendente']"
                    :series="[intval ($pendencias_documentos->entregue), intval($pendencias_documentos->nao_entregue)]"
                    :labels="['Entregues', 'Pendentes']"
                    onClickLegend="(chart, seriesIndex, opts) => {
                        const data = ['false', 'true'] ;
                        let url = `{{route('pedido.index')}}` ;
                        url += '?documentacao=' + data[seriesIndex] ;
                        Livewire.navigate(url)
                    }"
                    />
            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <x-apex.pie
                    :title="['align' => 'center', 'text' => 'TRT\'s']"
                    :series="$trt->pluck('qtde')->toArray()"
                    :labels="$trt->pluck('situacao')->toArray()"
                    onClickLegend="(chart, seriesIndex, opts) => {
                        const data = {!! json_encode($trt->pluck('situacao')->toArray()) !!}  ;
                        let url = `{{route('pedido.index')}}` ;
                        url += '?trt=' + data[seriesIndex] ;
                        Livewire.navigate(url)
                    }"
                    />
            </div>
        </div>
    </x-general.dashboard>
</x-app-layout>
