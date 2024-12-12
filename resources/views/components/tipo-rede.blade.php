@props(['tipoRede'])
@switch($tipoRede)
    @case(\App\Enums\TipoRede::BIFASICO->name)
        <x-badge warning label="{{\App\Enums\TipoRede::BIFASICO->label()}}">
        
        </x-badge>
        @break
    @case(\App\Enums\TipoRede::MONOFASICO->name)
    <x-badge secondary label="{{\App\Enums\TipoRede::MONOFASICO->label()}}" />
    @break
    @case(\App\Enums\TipoRede::TRIFASICO->name)
    <x-badge secondary label="{{\App\Enums\TipoRede::TRIFASICO->label()}}" />
    @break
    @default
        <x-badge secondary label="{{$tipoRede}}" />
@endswitch