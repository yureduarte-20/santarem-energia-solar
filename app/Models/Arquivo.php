<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $nome
 * @property string $path
 * @property string $arquivable_type
 * @property int $arquivable_id
 * @property string $sha_256
 * @property string $mimetype
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $arquivable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereArquivableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereArquivableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereMimetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereSha256($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arquivo withoutTrashed()
 * @mixin \Eloquent
 */
class Arquivo extends Model
{

    protected $fillable = ['nome', 'path', 'size', 'sha_256', 'arquivable_type', 'arquivable_id', 'mimetype'];

    public function arquivable()
    {
        return $this->morphTo('arquivable');
    }
}
