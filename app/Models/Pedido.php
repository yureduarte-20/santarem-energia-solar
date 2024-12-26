<?php

namespace App\Models;

use App\Enums\StatusPedido;
use App\Enums\TipoRede;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $numero
 * @property \Illuminate\Support\Carbon $data_pedido
 * @property \Illuminate\Support\Carbon $previsao_entrega
 * @property \Illuminate\Support\Carbon|null $data_entrega
 * @property int $user_id
 * @property int $qtde_contratado
 * @property int $qtde_pedido
 * @property int $cliente_id
 * @property string $valor_contratual
 * @property string $valor
 * @property string|null $descricao
 * @property TipoRede $tipo_rede
 * @property bool $entregue
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Cliente $cliente
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engenheiro> $homologacao_engenheiros
 * @property-read int|null $homologacao_engenheiros_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PedidoDocumento> $pedido_documentos
 * @property-read int|null $pedido_documentos_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereDataEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereDataPedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereEntregue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido wherePrevisaoEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereQtdeContratado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereQtdeEntregue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereTipoRede($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereValorContratual($value)
 * @property StatusPedido $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $instaladores
 * @property-read int|null $instaladores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rateio> $rateios
 * @property-read int|null $rateios_count
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereQtdePedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereStatus($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @mixin \Eloquent
 */
class Pedido extends Model
{
    protected $fillable = [
        'numero',
        'data_pedido',
        'previsao_entrega',
        'data_entrega',
        'qtde_contratado',
        'qtde_pedido',
        'cliente_id',
        'valor_contratual',
        'valor',
        'descricao',
        'tipo_rede',
        'entregue',
        'status'
    ];
    protected $casts = [
        'tipo_rede' => TipoRede::class,
        'data_entrega' => 'date:Y-m-d',
        'previsao_entrega' => 'date:Y-m-d',
        'data_pedido' => 'date:Y-m-d',
        'status' => StatusPedido::class
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'pedido_user')->withTrashed();
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function pedido_documentos()
    {
        return $this->hasMany(PedidoDocumento::class);
    }
    public function homologacao_engenheiros()
    {
        return $this->belongsToMany(Engenheiro::class, 'homologacao_engenheiros')
            ->withPivot(['data'])
            ->withTimestamps();
    }
    public function rateios()
    {
        return $this->hasMany(Rateio::class);
    }
    public function instaladores()
    {
        return $this->belongsToMany(User::class, 'instaladores_pedidos')->withTimestamps();
    }
}
