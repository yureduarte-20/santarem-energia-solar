<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacao extends Model
{
    use HasFactory;
    protected $fillable = [
        'pedido_id',
        'data_prevista',
        'data_instalada',
        'observacao'
    ];

    protected $casts = [
        'data_prevista' => 'date:Y-m-d',
        'data_instalada' => 'date:Y-m-d'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
