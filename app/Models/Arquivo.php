<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arquivo extends Model
{
    use SoftDeletes;
    protected $fillable = ['nome', 'path', 'size', 'sha_256', 'arquivable_type', 'arquivable_id'];

    public function arquivable()
    {
        return $this->morphTo('arquivable');
    }
}
