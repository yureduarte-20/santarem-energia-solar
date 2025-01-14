<?php

namespace App\Actions\App\Pedido;

use App\Actions\App\AbstractCrudAction;
use App\Enums\StatusRelogioBidirecional;
use App\Models\RelogioBidirecional;
use Illuminate\Validation\Rule;

class UpdateRelogioBidirecional extends AbstractCrudAction
{
    public function __construct(
        private RelogioBidirecional $relogioBidirecional
    ) {
    }

    public function update(array $input)
    {
        $validated = $this->validator($input)->validate();
        return $this->relogioBidirecional->update($validated);
    }

    public function rules()
    {
        return [
            'data_solicitacao' => 'required|date',
            'data_retorno' => [Rule::requiredIf(fn() => $this->relogioBidirecional->status != StatusRelogioBidirecional::SOLICITADO->name), 'date', 'after_or_equal:data_solicitacao'],
            'status' => 'required|in:' . join(',', StatusRelogioBidirecional::cases_name()),
            'observacoes' => [Rule::requiredIf(fn() => $this->relogioBidirecional->status != StatusRelogioBidirecional::SOLICITADO->name), 'min:3'],
        ];
    }
    public function attributes()
    {
        return [
            'data_solicitacao' => 'data de solicitação',
            'data_retorno' => 'data da resposta',
            'observacoes' => 'motivo'
        ];
    }
}
