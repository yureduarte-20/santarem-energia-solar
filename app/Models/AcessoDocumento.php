<?php

namespace App\Models;

use App\Enums\TipoConta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $pedido_documento_id
 * @property TipoConta $tipo_conta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PedidoDocumento $pedido_documento
 * @method static \Illuminate\Database\Eloquent\Builder|AcessoDocumento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcessoDocumento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcessoDocumento query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcessoDocumento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcessoDocumento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcessoDocumento wherePedidoDocumentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcessoDocumento whereTipoConta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcessoDocumento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
