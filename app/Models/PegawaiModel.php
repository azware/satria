<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nip', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'alamat', 'no_telp', 'email', 'tanggal_masuk', 'departemen_id', 'jabatan_id', 'foto'
    ];

    // Fungsi untuk mendapatkan data pegawai beserta nama departemen dan jabatan
    public function getPegawaiWithDetails($id = false)
    {
        if ($id === false) {
            return $this->select('pegawai.*, departemen.nama_departemen, jabatan.nama_jabatan')
                        ->join('departemen', 'departemen.id = pegawai.departemen_id', 'left')
                        ->join('jabatan', 'jabatan.id = pegawai.jabatan_id', 'left')
                        ->findAll();
        }

        return $this->select('pegawai.*, departemen.nama_departemen, jabatan.nama_jabatan')
                    ->join('departemen', 'departemen.id = pegawai.departemen_id', 'left')
                    ->join('jabatan', 'jabatan.id = pegawai.jabatan_id', 'left')
                    ->where(['pegawai.id' => $id])->first();
    }
}