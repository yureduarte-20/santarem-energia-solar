<?php
namespace App\Enums;
enum TipoTelhado
{
    case METALICO;
    case SOLO;
    case CERAMICO;
    case TELHADO;
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
            TipoTelhado::METALICO => __('Metálico'),
            TipoTelhado::FIBRO_CIMENTO_MADEIRA => __('Fibro Cimento (Madeira)'),
            TipoTelhado::FIBRO_CIMENTO_FERRO => __('Fibro Cimento (Ferro)'),
            TipoTelhado::TELHADO => 'Telhado'
        };
    }
    public static function fromString(string $value)
    {
        return match(str($value)->upper()->trim()->toString()){
            "FIBROCIMENTO (MADEIRA)" => TipoTelhado::FIBRO_CIMENTO_MADEIRA,
            "CERAMICO" => TipoTelhado::CERAMICO,
            "FIBROCIMENTO (FERRO)" => TipoTelhado::FIBRO_CIMENTO_FERRO,
            "SOLO" => TipoTelhado::SOLO,
            "METÁLICO", "METALICO" => TipoTelhado::METALICO,
            "TELHADO" => TipoTelhado::TELHADO,
            default => null
        };
    }
}
