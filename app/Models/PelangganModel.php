<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'nama_pelanggan';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['nama_pelanggan', 'alamat', 'no_hp','kode_pos'];
}
