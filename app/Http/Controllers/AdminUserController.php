<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function toggleBlock(User $user)
    {
        $this->authorize('toggle-block', [User::class, $user]);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return response($user->is_blocked, 200);
    }

    public function changeRole(Request $request, User $user)
    {
        $role = Role::fromValue($request->input('value'));

        $this->authorize('change-role', [User::class, $user, $role]);

        $user->role = $role->value;
        $user->save();

        return response($role->value, 200);
    }
}
