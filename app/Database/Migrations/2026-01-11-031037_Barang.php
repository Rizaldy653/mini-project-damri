<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
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
            'kode_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true
            ],
            'nama_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'harga' => [
                'type' => 'DECIMAL',
                'constraint' => 12,2
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 11
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
        // $this->forge->addKey('kode_barang');

        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}
