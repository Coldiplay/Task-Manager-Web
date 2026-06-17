<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
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
    public function view(User $user, Task $task): Response
    {
        return $user->role == Role::ADMIN
        || $task->author_id === $user->id
        || $task->assignee_id === $user->id
            ? Response::allow()
            : Response::denyWithStatus(403, 'You do not own this task or assigned to it.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->role === Role::ADMIN
            || $user->role == Role::MANAGER) {
            return Response::allow();
        }
        return Response::denyWithStatus(403, 'You are not allowed to create tasks');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): Response
    {
        return $task->author_id == $user->id
        || $task->assignee_id == $user->id
        || $user->role == Role::ADMIN
        || $user->role == Role::MANAGER
            ? Response::allow()
            : Response::denyWithStatus(403, 'You do not own this task or assigned to it.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): Response
    {
        return $task->author_id == $user->id || $user->role == Role::ADMIN
            ? Response::allow()
            : Response::denyWithStatus(403, 'You do not own this task.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        // 1. Admin can do anything
        if ($user->role === 'admin') {
            return true;
        }

        // Manager can do anything in their project
        if ($user->role === 'manager') {
            return $user->id === $task->project->author_id;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        // 1. Admin can do anything
        if ($user->role === 'admin') {
            return true;
        }

//        // Manager can do anything in their project
//        if ($user->role === 'manager') {
//            return $user->id === $task->project->author_id;
//        }

        return false;
    }

    public function assign(User $user, Task $task): Response
    {
        return $user->role == Role::ADMIN
        || $user->role == Role::MANAGER
            ? Response::allow()
            : Response::denyWithStatus(403, 'You do not have permission to assign this task.');
    }
}
