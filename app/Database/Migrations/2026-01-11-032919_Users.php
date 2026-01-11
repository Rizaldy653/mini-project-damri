<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);


        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true        
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('roles');


        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('permissions');


        $this->forge->addField([
            'user_id' => [
                'type' => 'INT'
            ],
            'role_id' => [
                'type' => 'INT'
            ]
        ]);

        $this->forge->addKey(['user_id', 'role_id'], true);
        $this->forge->createTable('user_roles');


        $this->forge->addField([
            'role_id' => [
                'type' => 'INT'
            ],
            'permission_id' => [
                'type' => 'INT'
            ]
        ]);

        $this->forge->addKey(['role_id', 'permission_id'], true);
        $this->forge->createTable('role_permissions');
    }

    public function down()
    {
        $this->forge->dropTable('role_permissions', true);
        $this->forge->dropTable('user_roles', true);
        $this->forge->dropTable('permissions', true);
        $this->forge->dropTable('roles', true);
        $this->forge->dropTable('users', true);
    }
}
