<?php

namespace App\Models;

use App\Enums\TipoConta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'user_id'
    ];
    protected $casts = [
        'type' => TipoConta::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
