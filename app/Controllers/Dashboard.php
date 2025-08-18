<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\DepartemenModel;
use App\Models\JabatanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $pegawaiModel = new PegawaiModel();
        $departemenModel = new DepartemenModel();
        $jabatanModel = new JabatanModel();

        // Siapkan data untuk dikirim ke view
        $data = [
            'total_pegawai' => $pegawaiModel->countAllResults(),
            'total_departemen' => $departemenModel->countAllResults(),
            'total_jabatan' => $jabatanModel->countAllResults(),
            // Anda bisa tambahkan statistik lain di sini, misal: pegawai baru bulan ini
        ];

        // Tampilkan partial view (hanya kontennya)
        return view('dashboard/index', $data);
    }
}