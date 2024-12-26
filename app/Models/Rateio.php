<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $nome
 * @property int $pedido_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Pedido $pedido
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio wherePedidoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rateio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
