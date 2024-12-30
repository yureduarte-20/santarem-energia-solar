@props(['series', 'horizontal' => false, 'title' => ''])
@php
    $id ='chart_id_'. \Str::random();
@endphp

<div id="{{ $id }}"></div>
@push('custom-scripts')
    <script>
        window.addEventListener('livewire:navigated', () => {
            const options = {
                chart: {
                    type: 'bar'
                },
                series: @json($series) ,
                title: @if (is_array($title))
                    @json($title)
                @else
                    {
                        text: '{{ $title }}'
                    }
                @endif ,
                plotOptions: {
                    bar: {
                        horizontal: {{ $horizontal ? 'true' : 'false' }},
                    }
                }
            };
            window.{{$id}} = new window.apex(document.querySelector('#{{ $id }}'), options)
            const chart = window.{{$id}} ;
            chart.render()
        }, { once:true })

        document.addEventListener('livewire:navigate', (event) => {
            const chart = window.{{$id}} ;
            chart?.destroy()
        }, { once:true });
    </script>
@endpush
