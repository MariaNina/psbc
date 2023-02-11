<?php


namespace App\Utilities;


use App\Models\UsersTbl;

class AccessRoute
{
    public static function user_permissions($id)
    {
        $user = UsersTbl::with('pages')->findOrFail($id);

        $permissions = $user->pages;

        $usersPermission = array();
        foreach ($permissions as $permission) {
            array_push($usersPermission, $permission->page_name);
        }

        return $usersPermission;
    }
}
