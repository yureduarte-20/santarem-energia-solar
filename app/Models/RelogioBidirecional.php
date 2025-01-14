<?php

namespace App\Models;

use App\Enums\StatusRelogioBidirecional;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelogioBidirecional extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'data_solicitacao',
        'data_retorno',
        'observacoes',
        'pedido_id'
    ];

    protected $casts = [
        'data_solicitacao' => 'date:Y-m-d',
        'data_retorno' => 'date:Y-m-d',
        'status' => StatusRelogioBidirecional::class
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
