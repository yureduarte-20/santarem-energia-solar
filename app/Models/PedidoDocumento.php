<?php

namespace App\Models;

use App\Interfaces\Arquivable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Query\Builder;

/**
 *
 *
 * @property int $id
 * @property int $pedido_id
 * @property int $tipo_documento_id
 * @property bool $entregue
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Arquivo|null $arquivo
 * @property-read \App\Models\Pedido $pedido
 * @property-read \App\Models\TipoDocumento $tipo_documento
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento whereEntregue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento wherePedidoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento whereTipoDocumentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PedidoDocumento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PedidoDocumento extends Model implements Arquivable
{
    protected $fillable =['pedido_id', 'tipo_documento_id', 'entregue', 'enviar_homologacao', 'user_id'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }
    public function arquivo()
    {
        return $this->morphOne(Arquivo::class, 'arquivable');
    }
    public function createNewArchive(array $input) : Model
    {
        $this->update([
            'entregue' => true
        ]);
        return $this->arquivo()->create($input);
    }
    public function getRelationshipBuilder(): MorphOne|MorphMany
    {
        return $this->arquivo();
    }
    public function acesso_documentos ()
    {
        return $this->hasMany(AcessoDocumento::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
