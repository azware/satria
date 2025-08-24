<?php

namespace App\Models;

use CodeIgniter\Model;

class DivisiModel extends Model
{
    protected $table            = 'divisi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_divisi', 'deskripsi'];

    // Aktifkan timestamp untuk created_at dan updated_at
    protected $useTimestamps = true;
}