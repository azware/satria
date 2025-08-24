<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // [DIUBAH] Tambahkan semua field baru dari database
    protected $allowedFields    = [
        'nip', 'nama_lengkap', 'email_pribadi', 'email_kantor', 'no_telp',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'golongan_darah',
        'nik_ktp', 'alamat_ktp', 'alamat_domisili', 'status_pernikahan', 'agama',
        'npwp', 'foto', 'tanggal_bergabung', 'status_aktif'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil data pegawai dengan jabatan dan departemen TERKINI.
     * Ini adalah query yang kompleks karena harus mencari riwayat jabatan terakhir.
     */
    public function getPegawaiWithDetails()
    {
        // Subquery untuk mendapatkan riwayat jabatan terakhir untuk setiap pegawai
        $subquery = "(
            SELECT rj.*
            FROM riwayat_jabatan_pegawai rj
            INNER JOIN (
                SELECT pegawai_id, MAX(tanggal_mulai) AS max_tanggal
                FROM riwayat_jabatan_pegawai
                GROUP BY pegawai_id
            ) rj_latest ON rj.pegawai_id = rj_latest.pegawai_id AND rj.tanggal_mulai = rj_latest.max_tanggal
        )";

        $builder = $this->db->table('pegawai p');
        $builder->select('
            p.id, p.nip, p.nama_lengkap, p.email_kantor, p.status_aktif,
            j.nama_jabatan, d.nama_departemen
        ');
        $builder->join("$subquery rj", 'rj.pegawai_id = p.id', 'left');
        $builder->join('jabatan j', 'j.id = rj.jabatan_id', 'left');
        $builder->join('departemen d', 'd.id = rj.departemen_id', 'left');

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil semua detail seorang pegawai tunggal, termasuk riwayat jabatan
     * dan status karyawan terkini.
     */
    public function getSinglePegawaiDetails($id)
    {
        // Data dasar pegawai
        $pegawai = $this->find($id);
        if (!$pegawai) return null;

        $db = \Config\Database::connect();

        // Riwayat Jabatan
        $pegawai['riwayat_jabatan'] = $db->table('riwayat_jabatan_pegawai rj')
            ->select('rj.*, j.nama_jabatan, d.nama_departemen')
            ->join('jabatan j', 'j.id = rj.jabatan_id')
            ->join('departemen d', 'd.id = rj.departemen_id')
            ->where('rj.pegawai_id', $id)
            ->orderBy('rj.tanggal_mulai', 'DESC')
            ->get()->getResultArray();

        // Riwayat Status
        $pegawai['riwayat_status'] = $db->table('riwayat_status_pegawai')
            ->where('pegawai_id', $id)
            ->orderBy('tanggal_mulai', 'DESC')
            ->get()->getResultArray();
            
        // Informasi Atasan Terkini (jika ada) dari riwayat jabatan terakhir
        if (!empty($pegawai['riwayat_jabatan'])) {
            $atasan_id = $pegawai['riwayat_jabatan'][0]['atasan_langsung_id'];
            if ($atasan_id) {
                $atasan = $this->select('id, nama_lengkap')->find($atasan_id);
                $pegawai['atasan_terkini'] = $atasan;
            }
        }

        return $pegawai;
    }
}