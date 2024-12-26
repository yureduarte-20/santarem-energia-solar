<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $cpf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pedido> $pedidos
 * @property-read int|null $pedidos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Engenheiro whereUpdatedAt($value)
 * @property int $conta_id
 * @property-read \App\Models\Conta $conta
 * @property-read mixed $nome
 * @method static \Illuminate\Database\Eloquent\Builder|Engenheiro whereContaId($value)
 * @mixin \Eloquent
 */
class Engenheiro extends Model
{
    protected $fillable = [ 'cpf', 'conta_id'];
    protected $appends =[
        'nome'
    ];

    public function pedidos() 
    {
        return $this->belongsToMany(Pedido::class, 'homologacao_engenheiros')
        ->withPivot(['data'])
        ->withTimestamps();
    }
    public function conta()
    {
        return $this->belongsTo(Conta::class);
    }
    public function nome() : Attribute
    {
        return Attribute::make(get: fn(mixed $value) => $this->conta()->first()->user->name );
    }
}
