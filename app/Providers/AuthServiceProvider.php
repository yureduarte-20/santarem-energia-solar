<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Cliente;
use App\Models\Engenheiro;
use App\Models\Pedido;
use App\Policies\ClientePolicy;
use App\Policies\EngenheiroPolicy;
use App\Policies\PedidoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Engenheiro::class => EngenheiroPolicy::class,
        Pedido::class => PedidoPolicy::class,
        Cliente::class => ClientePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
