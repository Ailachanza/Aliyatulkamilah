<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'nota';
    protected $primaryKey       = 'id_nomer';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id_nomer', 'tanggal'];
}
