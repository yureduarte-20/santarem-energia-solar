<?php

namespace App\Models;

use App\Enums\TipoConta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conta extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo',
        'user_id'
    ];
    protected $casts = [
        'tipo' => TipoConta::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function engenheiro()
    {
        return $this->hasOne(Engenheiro::class, 'conta_id');
    }
    
}
