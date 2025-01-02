@props(['series' => [], 'title' => '', 'xaxis' => []])
@php
    $id ='chart_id_'. \Str::random();
@endphp
    <div id="{{$id}}"></div>
@push('custom-scripts')
    <script>
    window.addEventListener('livewire:navigated', () => {
            const options = {
                chart: {
                    type: 'line'
                },
                series: @json($series) ,
                title: @if (is_array($title))
                    @json($title)
                @else
                    {
                        text: '{{ $title }}'
                    }
                @endif ,
                plotOptions: {},
                xaxis: @json($xaxis) ,
            };
            window.{{$id}} = new window.apex(document.querySelector('#{{ $id }}'), options)
            const chart = window.{{$id}} ;
            chart.render()
        }, { once:true })

        document.addEventListener('livewire:navigate', (event) => {
            const chart = window.{{$id}} ;
            chart?.destroy()
            delete window.{{$id}} ;

        }, { once:true });
    </script>
@endpush