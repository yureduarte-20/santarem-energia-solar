@props(['series', 'horizontal', 'title'])
@php
    $id = \Str::random();
@endphp

<div id="{{ $id }}"></div>
@push('custom-scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const options = {
                chart: {
                    type: 'bar'
                },
                series: @json($series),
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
            const chart = new window.apex(document.querySelector('#{{ $id }}'), options)
            chart.render()
        })
    </script>
@endpush
