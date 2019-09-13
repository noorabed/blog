<?php

namespace App\Policies;

use App\User;
use App\Blog;
use App\Role;
use App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any blogs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the blog.
     *
     * @param  \App\User  $user
     * @param  \App\Blog  $blog
     * @return mixed
     */
    public function view(User $user)
    {
       $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==4) {
                return true;
            }

        }
        return false;
    }

    /**
     * Determine whether the user can create blogs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //user role
       // dd($user->roles,$user);
      $user_role = \App\Role::find($user->role_id);
       // dd( $user_role->permissions);
        $role_permissions=$user_role->permissions;
        foreach ($role_permissions as $permission){
            if ($permission->id == 1) {
                return true;
            }

        }
        return false;

        //user permission role
 /** if (is_array($user)) {
            foreach ($user->roles as $role){
                foreach ($role->permissions as $permission) {
                    if ($permission->id == 1) {
                        return true;
                    }
                }
        }
                return false;
               }*/
}

    /**
     * Determine whether the user can update the blog.
     *
     * @param  \App\User  $user
     * @param  \App\Blog  $blog
     * @return mixed
     */
    public function update(User $user)
    {
        $user_role = \App\Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==2) {
                return true;
            }

        }
        return false;
    }


    /**
     * Determine whether the user can delete the blog.
     *
     * @param  \App\User  $user
     * @param  \App\Blog  $blog
     * @return mixed
     */
    public function delete(User $user)
    {
        $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==3) {
                return true;
            }

        }
        return false;
    }

    /**
     * Determine whether the user can restore the blog.
     *
     * @param  \App\User  $user
     * @param  \App\Blog  $blog
     * @return mixed
     */
    public function restore(User $user, Blog $blog)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the blog.
     *
     * @param  \App\User  $user
     * @param  \App\Blog  $blog
     * @return mixed
     */
    public function forceDelete(User $user, Blog $blog)
    {
        //
    }

    public function category(User $user)
    {
        $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==5) {
                return true;
            }
        }
        return false;
    }

    public function editcategory(User $user)
    {
        $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==6) {
                return true;
            }
        }
        return false;
    }

    public function deletecategory(User $user)
    {
        $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==7) {
                return true;
            }
        }
        return false;
    }
    public function deletetag(User $user)
    {
        $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==11) {
                return true;
            }
        }
        return false;
    }


}
