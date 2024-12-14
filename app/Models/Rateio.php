<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rateio extends Model
{
    public $fillable=[
        'pedido_id',
        'nome'
    ];
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
