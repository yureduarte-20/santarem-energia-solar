<?php
namespace App\Actions\App\Pendencia;

use App\Models\Engenheiro;
use App\Models\Pendencia;
use App\Notifications\PendingSolvedNotification;
use Illuminate\Support\Facades\Validator;

class UpdatePendenciaStatusAction
{
    public function getRules()
    {
        return [
            'atentida' => 'required|boolean'
        ];
    }

    public function __invoke(Pendencia $pendencia)
    {
        if(!$pendencia->atendida)
        {
            $pendencia->atendida = true;
            return tap($pendencia->save(), function($result)use($pendencia){
                $result and $pendencia->pedido->homologacao_engenheiros->each(function(Engenheiro $eng) use($pendencia){
                    $eng->conta->user->notifyNow(
                        new PendingSolvedNotification(
                            $pendencia
                        )
                    );
                });
            });

        }
        return true;
    }
}
