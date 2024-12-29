<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'atendida',
        'conteudo',
        'pedido_id',
        'engenheiro_id'
    ];
    public function engenheiro()
    {
        return $this->belongsTo(Engenheiro::class);
    }
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
