<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $pedido_id
 * @property int $metodo_pagamento_id
 * @property string $valor
 * @property bool $quitado
 * @property \Illuminate\Support\Carbon $data_pagamento
 * @property \Illuminate\Support\Carbon $vencimento
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\MetodoPagamento $metodo_pagamento
 * @property-read \App\Models\Pedido $pedido
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereDataPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereMetodoPagamentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento wherePedidoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereQuitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento whereVencimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoMetodoPagamento withoutTrashed()
 * @mixin \Eloquent
 */
class PedidoMetodoPagamento extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'pedido_id',
        'metodo_pagamento_id',
        'valor',
        'quitado',
        'data_pagamento',
        'vencimento'
    ];
    protected $casts = [
        'data_pagamento' => 'date:Y-m-d',
        'vencimento' => 'date:Y-m-d'
    ];
    public function metodo_pagamento()
    {
        return $this->belongsTo(MetodoPagamento::class);
    }
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
  
}
