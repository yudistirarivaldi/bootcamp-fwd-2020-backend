<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Add models
use App\Models\ManagementAccess\Role;

// add library
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // get all data already login
        $user = \Auth::user();

        // checking validation middleware
        // system on or off
        // user active or not
        if(!app()->runningInConsole() && $user)
        {
            // get role have data permission
            $roles              = Role::with('permission')->get();
            // why null because this array save the $roles
            $permissionsArray   = [];

            // nested loop
            // looping for role (where table role)
            foreach($roles as $role)
            {
                // looping for permission ( where table permission_role )
                foreach($role->permission as $permission)
                {
                    $permissionsArray[$permission->title][] = $role->id;
                }
            }

            // check user role
            foreach($permissionsArray as $title => $roles) {
                Gate::define($title, function(\App\Models\User $user)

                use ($roles) {
                    return count(array_intersect($user->role->pluck('id')->toArray(), $roles)) > 0;
            });
        }
    }

        return $next($request);
    }
}
