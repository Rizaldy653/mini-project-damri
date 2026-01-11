<?php

namespace App\Libraries;

use Config\Database;

class AuthService
{
    public static function can($permission)
    {
        $db = Database::connect();

        $userId = session()->get('user_id');

        $result = $db->table('permissions p')
            ->select('p.name')
            ->join('role_permissions rp', 'rp.permission_id = p.id')
            ->join('user_roles ur', 'ur.role_id = rp.role_id')
            ->where('ur.user_id', $userId)
            ->where('p.name', $permission)
            ->get()
            ->getRow();

        return $result !== null;
    }
}
