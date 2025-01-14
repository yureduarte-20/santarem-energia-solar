<?php
namespace App\Enums;
enum StatusRelogioBidirecional
{
    case SOLICITADO;
    case TROCADO;
    case NEGADO;

    public function label()
    {
        return match($this){
            StatusRelogioBidirecional::SOLICITADO => "Solicitado",
            StatusRelogioBidirecional::TROCADO => 'Trocado',
            StatusRelogioBidirecional::NEGADO => 'Negado'
        };
    }
    public static function cases_name()
    {
        return array_map(fn($case) => $case->name, StatusRelogioBidirecional::cases());
    }
}
