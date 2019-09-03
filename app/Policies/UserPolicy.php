<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function create(User $user)
    {

        $user_role = Role::find($user->role_id);
        $role_permissions=$user_role->permissions;
        foreach ($role_permissions as $permission){
            if ($permission->id == 13) {
                return true;
            }

        }
        return false;

    }

    public function update(User $user)
    {
        $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==14) {
                return true;
            }

        }
        return false;
    }
    public function delete(User $user)
    {
        $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==15) {
                return true;
            }

        }
        return false;
    }
    public function updatesetting(User $admin)
    {
        $admin=Role::whereName('admin')->first();
        $role_permissions = $admin->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==17) {
                return true;
            }

        }
        return false;
    }
}
