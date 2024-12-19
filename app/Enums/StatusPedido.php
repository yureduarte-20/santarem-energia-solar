<?php
namespace App\Enums;
enum  StatusPedido {
    case FINALIZADO;
    case ENVIADO_ENGENHEIRO;
    case ENVIAR_ENGENHEIRO;
    case HOMOLOGADO;

    public function label()
    {
        return match ($this) {
            StatusPedido::FINALIZADO => "Finalizado",
            StatusPedido::ENVIADO_ENGENHEIRO => "Enviado para engenheiros",
            StatusPedido::ENVIAR_ENGENHEIRO=> "Enviar para engenheiros",
            StatusPedido::HOMOLOGADO => "Homologado"
        };
    }
}