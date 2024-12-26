<?php

namespace App\Models;

use App\Enums\TipoConta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property TipoConta $tipo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Engenheiro|null $engenheiro
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Conta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conta query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conta whereUserId($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function engenheiro()
    {
        return $this->hasOne(Engenheiro::class, 'conta_id');
    }
    
}
