<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente query()
 * @mixin \Eloquent
 */
class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email'
    ];
    public function endereco()
    {
        return $this->morphOne(Endereco::class, 'addressable');
    }
}
