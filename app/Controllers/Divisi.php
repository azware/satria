<?php

namespace App\Controllers;

use App\Models\DivisiModel;
use CodeIgniter\API\ResponseTrait;

class Divisi extends BaseController
{
    use ResponseTrait;

    protected $divisiModel;

    public function __construct()
    {
        $this->divisiModel = new DivisiModel();
    }

    // Method untuk menampilkan view utama (partial view)
    public function index()
    {
        return view('divisi/index');
    }

    // Method untuk mengambil data bagi DataTables (format JSON)
    public function ajax_list()
    {
        if ($this->request->isAJAX()) {
            $data = $this->divisiModel->findAll();
            return $this->response->setJSON(['data' => $data]);
        }
    }

    // Method untuk mengambil data tunggal untuk form edit (format JSON)
    public function ajax_edit($id)
    {
        if ($this->request->isAJAX()) {
            $data = $this->divisiModel->find($id);
            return $this->respond($data);
        }
    }

    // Method untuk menyimpan data (baik tambah maupun edit)
    public function ajax_save()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            
            // Aturan validasi
            $rules = [
                'nama_divisi' => 'required|is_unique[divisi.nama_divisi,id,{id}]',
            ];

            if (!$this->validate($rules)) {
                return $this->fail($validation->getErrors());
            }

            $id = $this->request->getPost('id');
            $data = [
                'nama_divisi' => $this->request->getPost('nama_divisi'),
                'deskripsi'   => $this->request->getPost('deskripsi'),
            ];
            
            if (empty($id)) { // Insert data baru
                $this->divisiModel->insert($data);
            } else { // Update data yang ada
                $this->divisiModel->update($id, $data);
            }

            return $this->respondCreated(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        }
    }

    // Method untuk menghapus data
    public function ajax_delete($id)
    {
        if ($this->request->isAJAX()) {
            // (Opsional) Tambahkan pengecekan apakah ada departemen di bawah divisi ini sebelum dihapus
            if ($this->divisiModel->delete($id)) {
                return $this->respondDeleted(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
            }
            return $this->fail('Gagal menghapus data.');
        }
    }
}