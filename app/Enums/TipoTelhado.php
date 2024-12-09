<?php
namespace App\Enums;
enum TipoTelhado
{
    case TELHADO;
    case SOLO;
    case CERAMICO;
    case FIBRO_CIMENTO_MADEIRA;
    case FIBRO_CIMENTO_FERRO;
    public static function values()
    {
        return array_map( fn(TipoTelhado $item) => $item->name, TipoTelhado::cases() );
    }
    public function label()
    {
        return match($this){
            TipoTelhado::CERAMICO => __('Cerâmico'),
            TipoTelhado::SOLO => __('Solo'),
            TipoTelhado::TELHADO => __('Telhado'),
            TipoTelhado::FIBRO_CIMENTO_MADEIRA => __('Fibro Cimento (Madeira)'),
            TipoTelhado::FIBRO_CIMENTO_FERRO => __('Fibro Cimento (Ferro)')
        };
    }
}