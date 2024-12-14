<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $nome
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pedido> $pedidos
 * @property-read int|null $pedidos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PedidoMetodoPagamento> $pedidos_metodo_pagamentos
 * @property-read int|null $pedidos_metodo_pagamentos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPagamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPagamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPagamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPagamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPagamento whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPagamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPagamento whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPagamento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MetodoPagamento extends Model
{
    protected $fillable = ['nome'];
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_metodo_pagamentos')
            ->withPivot([
                'pedido_id',
                'metodo_pagamento_id',
                'valor',
                'quitado',
                'data_pagamento',
                'vencimento'
            ])
            ->withTimestamps();
    }
    public function pedidos_metodo_pagamentos()
    {
        return $this->hasMany(PedidoMetodoPagamento::class);
    }

}
