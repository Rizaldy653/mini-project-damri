<?php

namespace App\Models;

use CodeIgniter\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_barang', 
        'harga', 
        'stok',
        'status'
    ];

    protected $useTimestamps = true;

    protected $returnType = 'array';
}
