<?php

namespace App\Models;

use App\Enums\TipoRede;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'numero',
        'data_pedido',
        'previsao_entrega',
        'data_entrega',
        'user_id',
        'qtde_contratado',
        'qtde_entregue',
        'cliente_id', 
        'valor_contratual',
        'valor',
        'descricao',
        'tipo_rede',
        'entregue',
    ];
    protected $casts = [
        'tipo_rede' => TipoRede::class,
        'data_entrega' => 'date:Y-m-d',
        'previsao_entrega' => 'date:Y-m-d',
        'data_pedido' => 'date:Y-m-d',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function pedido_documentos()
    {
        return $this->hasMany(PedidoDocumento::class);
    }

}
