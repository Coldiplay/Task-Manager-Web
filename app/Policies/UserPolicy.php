<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        return $user->role == Role::ADMIN
        || $user->id == $model->id
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        return Response::denyWithStatus(403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): Response
    {
        return Response::denyWithStatus(403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): Response
    {
        return Response::denyWithStatus(403);
    }

    public function toggleBlock(User $user, User $model): Response
    {
        return $user->role == Role::ADMIN
            ? Response::allow()
            : Response::denyWithStatus(403, 'You are not allowed to toggle ban.');
    }

    public function changeRole(User $user, User $model, Role $role): Response
    {
        return $user->role == Role::ADMIN
            ? Response::allow()
            : Response::denyWithStatus(403, 'You are not allowed to change role.');
    }
}
