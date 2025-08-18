<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $table            = 'departemen';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_departemen'];

    // Kita bisa menambahkan timestamp jika perlu
    protected $useTimestamps = false;
}