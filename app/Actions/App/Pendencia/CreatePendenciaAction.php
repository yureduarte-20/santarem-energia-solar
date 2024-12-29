<?php
namespace App\Actions\App\Pendencia;

use App\Enums\TipoConta;
use App\Models\Pendencia;
use App\Models\User;
use App\Notifications\NotifyPendingProject;
use Illuminate\Support\Facades\Validator;

class CreatePendenciaAction
{
    public function getRules(): array
    {
        return [
            'pedido_id' => 'required|exists:pedidos,id',
            'engenheiro_id' => 'required|exists:engenheiros,id',
            'conteudo' => 'required|string'
        ];
    }
    public function getAttributes()
    {
        return [
            'pedido_id' => 'pedido',
            'engenheiro_id' => 'engenheiro'
        ];
    }

    public function __invoke(array $input, string $errorBag = null)
    {
        $validator = Validator::make($input, $this->getRules(), [], $this->getAttributes());
        $validated = $errorBag ? $validator->validateWithBag($errorBag) : $validator->validate();
        return tap(Pendencia::create($validated), function($pendencia){
            User::role(TipoConta::ADMIN->name)->each(fn($user) => $user->notifyNow(
                new NotifyPendingProject(
                    $pendencia
                )
            ));
        });
    }
}