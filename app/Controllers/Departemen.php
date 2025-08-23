<?php

namespace App\Controllers;

use App\Models\DepartemenModel;
use App\Models\DivisiModel; // [BARU] Impor model Divisi
use CodeIgniter\API\ResponseTrait;

class Departemen extends BaseController
{
    use ResponseTrait;

    protected $departemenModel;
    protected $divisiModel; // [BARU] Deklarasikan properti

    public function __construct()
    {
        $this->departemenModel = new DepartemenModel();
        $this->divisiModel = new DivisiModel(); // [BARU] Inisialisasi model
    }

    public function index()
    {
        // [DIUBAH] Kirim data divisi ke view untuk mengisi dropdown
        $data['divisi'] = $this->divisiModel->findAll();
        return view('departemen/index', $data);
    }

    public function ajax_list()
    {
        if ($this->request->isAJAX()) {
            // [DIUBAH] Gunakan fungsi baru yang sudah di-JOIN
            $data = $this->departemenModel->getDepartemenWithDetails();
            return $this->response->setJSON(['data' => $data]);
        }
    }

    public function ajax_edit($id)
    {
        if ($this->request->isAJAX()) {
            // Kita hanya perlu data departemen, tidak perlu join di sini
            $data = $this->departemenModel->find($id);
            return $this->respond($data);
        }
    }

    public function ajax_save()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            
            $rules = [
                'nama_departemen' => 'required|is_unique[departemen.nama_departemen,id,{id}]',
                'divisi_id' => 'required|integer', // [BARU] Validasi untuk divisi_id
            ];

            if (!$this->validate($rules)) {
                return $this->fail($validation->getErrors());
            }

            $id = $this->request->getPost('id');
            $data = [
                'nama_departemen' => $this->request->getPost('nama_departemen'),
                'divisi_id' => $this->request->getPost('divisi_id'), // [BARU] Ambil data divisi_id
            ];
            
            if (empty($id)) {
                $this->departemenModel->insert($data);
            } else {
                $this->departemenModel->update($id, $data);
            }

            return $this->respondCreated(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        }
    }

    public function ajax_delete($id)
    {
        if ($this->request->isAJAX()) {
            // (Opsional) Tambahkan pengecekan apakah ada pegawai di departemen ini sebelum dihapus
            if ($this->departemenModel->delete($id)) {
                return $this->respondDeleted(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
            }
            return $this->fail('Gagal menghapus data.');
        }
    }
}