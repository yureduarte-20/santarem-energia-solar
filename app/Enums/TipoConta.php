<?php
namespace App\Enums;
enum TipoConta {
    case ENGENHEIRO;
    case ADMIN;
    case VENDEDOR;
    case INSTALADOR;

    public function label()
    {
        return match($this){
            TipoConta::ENGENHEIRO => 'Engenheiro',
            TipoConta::ADMIN => 'Administrador',
            TipoConta::VENDEDOR => 'Vendedor',
            TipoConta::INSTALADOR => 'Instalador'
        };
    }

    public static function cases_names()
    {
        return array_map(fn($item) => $item->name, TipoConta::cases());
    }

}
