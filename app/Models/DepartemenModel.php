<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $table            = 'departemen';
    protected $primaryKey       = 'id';
    // [DIUBAH] Tambahkan 'divisi_id'
    protected $allowedFields    = ['nama_departemen', 'divisi_id'];

    protected $useTimestamps = true; // Mari kita aktifkan timestamp

    // [BARU] Fungsi untuk mendapatkan data departemen beserta nama divisi
    public function getDepartemenWithDetails($id = false)
    {
        $builder = $this->db->table('departemen');
        $builder->select('departemen.*, divisi.nama_divisi');
        $builder->join('divisi', 'divisi.id = departemen.divisi_id', 'left'); // LEFT JOIN agar departemen tanpa divisi tetap tampil

        if ($id === false) {
            return $builder->get()->getResultArray();
        }

        return $builder->where('departemen.id', $id)->get()->getRowArray();
    }
}