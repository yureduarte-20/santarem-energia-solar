<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PedidoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-pedidos');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pedido $pedido): bool
    {
        return $user->hasPermissionTo('show-pedidos');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-pedidos');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pedido $pedido): bool
    {
        return $user->hasPermissionTo('edit-pedidos');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pedido $pedido): bool
    {
        return $user->hasPermissionTo('delete-pedidos');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pedido $pedido): bool
    {
        return $user->hasPermissionTo('delete-pedidos');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pedido $pedido): bool
    {
        return $user->hasPermissionTo('delete-pedidos');
    }
}
