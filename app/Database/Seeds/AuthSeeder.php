<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Config\Database;

class AuthSeeder extends Seeder
{
    public function run()
    {
        $db = Database::connect();

        $roles = [
            ['name' => 'super_admin'],
            ['name' => 'admin'],
            ['name' => 'user'],
        ];

        $db->table('roles')->insertBatch($roles);

        $roleSuperAdmin = $db->table('roles')->where('name', 'super_admin')->get()->getRow()->id;
        $roleAdmin      = $db->table('roles')->where('name', 'admin')->get()->getRow()->id;
        $roleUser       = $db->table('roles')->where('name', 'user')->get()->getRow()->id;

        $permissions = [
            ['name' => 'manage_users'],
            ['name' => 'manage_roles'],
            ['name' => 'manage_permissions'],
            ['name' => 'manage_barang'],
            ['name' => 'view_barang'],
            ['name' => 'view_dashboard'],
        ];

        $db->table('permissions')->insertBatch($permissions);

        $permissionIds = [];
        foreach ($permissions as $permission) {
            $permissionIds[$permission['name']] =
                $db->table('permissions')->where('name', $permission['name'])->get()->getRow()->id;
        }

        foreach ($permissionIds as $permissionId) {
            $db->table('role_permissions')->insert([
                'role_id'       => $roleSuperAdmin,
                'permission_id' => $permissionId
            ]);
        }

        $adminPermissions = [
            'manage_users',
            'manage_barang',
            'view_barang',
            'view_dashboard',
        ];

        foreach ($adminPermissions as $perm) {
            $db->table('role_permissions')->insert([
                'role_id'       => $roleAdmin,
                'permission_id' => $permissionIds[$perm]
            ]);
        }

        $userPermissions = [
            'view_barang',
            'view_dashboard',
        ];

        foreach ($userPermissions as $perm) {
            $db->table('role_permissions')->insert([
                'role_id'       => $roleUser,
                'permission_id' => $permissionIds[$perm]
            ]);
        }

        $db->table('users')->insert([
            'name'       => 'Super Admin',
            'email'      => 'superadmin@test.com',
            'password'   => password_hash('password123', PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $userId = $db->insertID();

        $db->table('user_roles')->insert([
            'user_id' => $userId,
            'role_id' => $roleSuperAdmin
        ]);
    }
}
