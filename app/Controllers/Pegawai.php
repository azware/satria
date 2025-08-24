<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\DivisiModel;
use App\Models\DepartemenModel;
use App\Models\JabatanModel;
use App\Models\RiwayatJabatanPegawaiModel;
use App\Models\RiwayatStatusPegawaiModel;
use CodeIgniter\API\ResponseTrait;

class Pegawai extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // Data ini untuk mengisi dropdown di form
        $pegawaiModel = new PegawaiModel();
        $data['jabatan'] = (new JabatanModel())->findAll();
        $data['departemen'] = (new DepartemenModel())->findAll();
        $data['pegawai_list'] = $pegawaiModel->select('id, nama_lengkap')->where('status_aktif', 'Aktif')->findAll();

        return view('pegawai/index', $data);
    }
    
    public function ajax_list()
    {
        if ($this->request->isAJAX()) {
            $pegawaiModel = new PegawaiModel();
            $data = $pegawaiModel->getPegawaiWithDetails();
            return $this->response->setJSON(['data' => $data]);
        }
    }

    public function ajax_detail($id)
    {
        if ($this->request->isAJAX()) {
            $pegawaiModel = new PegawaiModel();
            $data = $pegawaiModel->getSinglePegawaiDetails($id);
            return $this->respond($data);
        }
    }

    public function ajax_save()
    {
        if ($this->request->isAJAX()) {
            $pegawaiModel = new PegawaiModel();
            $riwayatJabatanModel = new RiwayatJabatanPegawaiModel();
            $riwayatStatusModel = new RiwayatStatusPegawaiModel();

            // Aturan validasi yang lebih lengkap
            $rules = [
                'nip' => 'required|is_unique[pegawai.nip,id,{id}]',
                'nama_lengkap' => 'required',
                'email_kantor' => 'required|valid_email|is_unique[pegawai.email_kantor,id,{id}]',
                'tanggal_bergabung' => 'required|valid_date',
                // Validasi untuk data riwayat penempatan awal
                'jabatan_id' => 'required|integer',
                'departemen_id' => 'required|integer',
                'status_karyawan' => 'required',
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors());
            }

            // Mulai transaksi database
            $this->db->transStart();

            // Data untuk tabel `pegawai`
            $pegawaiData = [
                'nip' => $this->request->getPost('nip'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'email_kantor' => $this->request->getPost('email_kantor'),
                'email_pribadi' => $this->request->getPost('email_pribadi'),
                'no_telp' => $this->request->getPost('no_telp'),
                'nik_ktp' => $this->request->getPost('nik_ktp'),
                'status_pernikahan' => $this->request->getPost('status_pernikahan'),
                'tanggal_bergabung' => $this->request->getPost('tanggal_bergabung'),
            ];

            // Simpan atau update data pegawai
            if ($this->request->getPost('id')) {
                // Proses update (hanya data pribadi)
                $pegawaiModel->update($this->request->getPost('id'), $pegawaiData);
                $pegawaiId = $this->request->getPost('id');
            } else {
                // Proses insert (data baru)
                $pegawaiModel->insert($pegawaiData);
                $pegawaiId = $pegawaiModel->getInsertID();

                // Buat Riwayat Jabatan Awal
                $riwayatJabatanData = [
                    'pegawai_id' => $pegawaiId,
                    'jabatan_id' => $this->request->getPost('jabatan_id'),
                    'departemen_id' => $this->request->getPost('departemen_id'),
                    'atasan_langsung_id' => $this->request->getPost('atasan_langsung_id') ?: null,
                    'tanggal_mulai' => $this->request->getPost('tanggal_bergabung'),
                    'jenis_perubahan' => 'Penempatan Awal',
                ];
                $riwayatJabatanModel->insert($riwayatJabatanData);

                // Buat Riwayat Status Awal
                $riwayatStatusData = [
                    'pegawai_id' => $pegawaiId,
                    'status_karyawan' => $this->request->getPost('status_karyawan'),
                    'tanggal_mulai' => $this->request->getPost('tanggal_bergabung'),
                    'keterangan' => 'Status Awal Saat Bergabung',
                ];
                $riwayatStatusModel->insert($riwayatStatusData);
            }

            // Selesaikan transaksi
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->fail('Gagal menyimpan data ke database.');
            }

            return $this->respondCreated(['status' => 'success', 'message' => 'Data pegawai berhasil disimpan.']);
        }
    }
}