<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TriggerKodeBarang extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TRIGGER trg_kode_barang
            BEFORE INSERT ON barang
            FOR EACH ROW
            BEGIN
                DECLARE urut INT;
                SELECT IFNULL(MAX(CAST(SUBSTRING(kode_barang, 5) AS UNSIGNED)), 0) + 1
                INTO urut FROM barang;
                SET NEW.kode_barang = CONCAT('BVA-', LPAD(urut, 3, '0'));
            END
        ");
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS trg_kode_barang");
    }
}
