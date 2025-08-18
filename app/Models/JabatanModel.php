<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table            = 'jabatan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_departemen'];

    // Kita bisa menambahkan timestamp jika perlu
    protected $useTimestamps = false;
}