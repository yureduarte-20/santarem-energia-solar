<?php
namespace App\Enums;

enum TipoRede
{
    case MONOFASICO;
    case BISAFICO;
    case TRIFASICO;
    public static function values()
    {
        return array_map( fn($item) => $item->value, TipoRede::cases() );
    }

    public function label()
    {
        return match ($this) {
            TipoRede::MONOFASICO => __('Monofásico'),
            TipoRede::BISAFICO=> __('Bifásico'),
            TipoRede::TRIFASICO => __('Trifásico'),
        };
    }
}