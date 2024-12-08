<?php

namespace App\Models;

use App\Interfaces\Arquivable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Query\Builder;

class PedidoDocumento extends Model implements Arquivable
{
    protected $fillable =['pedido_id', 'tipo_documento_id', 'entregue'];

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
        return $this->arquivo()->create($input);
    }
    public function getRelationshipBuilder(): MorphOne|MorphMany
    {
        return $this->arquivo();
    }
}
