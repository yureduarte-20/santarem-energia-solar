<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HomologacaoEngenheiro extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'data',
        'data_homologacao',
        'observacoes'
    ];
    protected $casts = [
        'data' => 'date:Y-m-d',
        'data_homologacao' => 'date:Y-m-d',
    ];
}
