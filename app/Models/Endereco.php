<?php

namespace App\Models;

use App\Enums\TipoTelhado;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco query()
 * @property int $id
 * @property string|null $rua
 * @property string|null $numero
 * @property string|null $bairro
 * @property string $cep
 * @property string $cidade
 * @property string $uf
 * @property string $addressable_type
 * @property int $addressable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property TipoTelhado|null $tipo_telhado
 * @property-read Model|\Eloquent $addressable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereRua($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereTipoTelhado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Endereco extends Model
{
    protected $fillable = [
        'rua',
        'numero',
        'bairro',
        'cidade',
        'uf',
        'cep',
        'tipo_telhado'
    ];
    protected $casts =[
        'tipo_telhado' => TipoTelhado::class
    ];
    public function addressable()
    {
        return $this->morphTo('addressable');
    }
}
