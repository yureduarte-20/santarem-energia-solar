<?php

namespace App\Policies;

use App\Models\PedidoDocumento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PedidoDocumentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-docs');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PedidoDocumento $pedidoDocumento): bool
    {
        return $user->hasPermissionTo('show-docs');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-docs');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PedidoDocumento $pedidoDocumento): bool
    {
        return $user->hasPermissionTo('edit-docs');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PedidoDocumento $pedidoDocumento): bool
    {
        return $user->hasPermissionTo('delete-docs');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PedidoDocumento $pedidoDocumento): bool
    {
        return $user->hasPermissionTo('delete-docs');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PedidoDocumento $pedidoDocumento): bool
    {
        return $user->hasPermissionTo('delete-docs');
    }
}
