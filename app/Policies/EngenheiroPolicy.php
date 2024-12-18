<?php

namespace App\Policies;

use App\Models\Engenheiro;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EngenheiroPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-engenheiros');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Engenheiro $engenheiro): bool
    {
        return $user->hasPermissionTo('show-engenheiros');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-engenheiros');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Engenheiro $engenheiro): bool
    {
        return $user->hasPermissionTo('edit-engenheiros');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Engenheiro $engenheiro): bool
    {
        return $user->hasPermissionTo('delete-engenheiros');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Engenheiro $engenheiro): bool
    {
        return $user->hasPermissionTo('delete-engenheiros');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Engenheiro $engenheiro): bool
    {
        return $user->hasPermissionTo('delete-engenheiros');
    }
}
