<?php

namespace App\Policies;

use App\Models\project;
use App\Models\User;
use App\Models\task;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */

    public function viewAny(User $user): bool
    {
        // 1. Admin can do anything
        if ($user->role === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, task $task): bool
    {

        // 1. Admin can do anything
        if ($user->role === 'admin') {
            return true;
        }

        // Manager can do anything in their project
        if ($user->role === 'manager') {
            return $user->id === $task->project->author_id;
        }

        // Executor is lox
        if ($user->role === 'executor') {
            return $user->id === $task->assignee_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, int $project_id): bool
    {
        // 1. Admin can do anything
        if ($user->role === 'admin') {
            return true;
        }

        // Manager can do anything in their project
        if ($user->role === 'manager') {
            return $user->id === project::all()->find(['id' => $project_id])->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, task $task): bool
    {
        // 1. Admin can do anything
        if ($user->role === 'admin') {
            return true;
        }

        // Manager can do anything in their project
        if ($user->role === 'manager') {
            return $user->id === $task->project->author_id;
        }

        // Executor is lox
        if ($user->role === 'executor') {
            return $user->id === $task->assignee_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, task $task): bool
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
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, task $task): bool
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
    public function forceDelete(User $user, task $task): bool
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
}
