<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UsersTbl;


class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $type  check what type of route is this
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {

        $user = UsersTbl::with('pages')->findOrFail(session('user')->id);

        $permissions = $user->pages;

        $usersPermission = array();
        foreach ($permissions as $permission) {
            array_push($usersPermission, $permission->page_name);
        }

        // Check the all the permissions of a user if it has the correct permission type $type
        if (!in_array($type, $usersPermission)) {
            abort(403);
        }

        return $next($request);

    }
}
