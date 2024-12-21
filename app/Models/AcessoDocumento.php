<?php

namespace App\Models;

use App\Enums\TipoConta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcessoDocumento extends Model
{
    use HasFactory;
    protected $fillable = ['tipo_conta', 'pedido_documento_id'];
    protected $casts = [
        'tipo_conta' => TipoConta::class
    ];

    public function pedido_documento()
    {
        return $this->belongsTo(PedidoDocumento::class);
    }
}
