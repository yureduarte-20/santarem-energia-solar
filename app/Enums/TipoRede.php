<?php
namespace App\Enums;

enum TipoRede
{
    case MONOFASICO;
    case BIFASICO;
    case TRIFASICO;
    public static function values()
    {
        return array_map(fn(TipoRede $item) => $item->name, TipoRede::cases());
    }

    public function label()
    {
        return match ($this) {
            TipoRede::MONOFASICO => __('Monofásico'),
            TipoRede::BIFASICO => __('Bifásico'),
            TipoRede::TRIFASICO => __('Trifásico'),
        };
    }
    public static function fromString(string $string)
    {
        $option = str($string)->upper()->replace('Á', 'A')->trim()->toString();
        return match ($option) {
            'MONOFASICA' => TipoRede::MONOFASICO,
            'BIFASICO' => TipoRede::BIFASICO,
            'TRIFASICO' => TipoRede::TRIFASICO,
            default => null
        };
    }
}