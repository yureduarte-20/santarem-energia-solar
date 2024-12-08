<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Endereco query()
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
        'cep'
    ];
    public function addressable()
    {
        return $this->morphTo('addressable');
    }
}
