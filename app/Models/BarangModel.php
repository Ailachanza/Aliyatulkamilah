<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'barang';
    protected $primaryKey       = 'no_barang';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['no_barang', 'nama_barang','satuan', 'harga'];
}
