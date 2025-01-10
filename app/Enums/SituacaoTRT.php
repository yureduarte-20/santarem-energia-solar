<?php
namespace App\Enums;
enum  SituacaoTRT {
    case PENDENTE;
    case PAGO;

    public function label()
    {
        return match ($this) {
            SituacaoTRT::PENDENTE => "Pendente",
            SituacaoTRT::PAGO => "Pago",
        };
    }
    public static function cases_names()
    {
        return array_map(fn($item) => $item->name, SituacaoTRT::cases());
    }
}
