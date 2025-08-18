<?php

namespace App\Controllers;

use App\Models\JabatanModel;
use CodeIgniter\API\ResponseTrait;

class Jabatan extends BaseController
{
    use ResponseTrait;

    protected $jabatanModel;

    public function __construct()
    {
        $this->jabatanModel = new jabatanModel();
    }

    // Method untuk menampilkan view utama
    public function index()
    {
        return view('jabatan/index');
    }

    // Method untuk mengambil data bagi DataTables
    public function ajax_list()
    {
        if ($this->request->isAJAX()) {
            $data = $this->jabatanModel->findAll();
            return $this->response->setJSON(['data' => $data]);
        }
    }

    // Method untuk mengambil data tunggal untuk form edit
    public function ajax_edit($id)
    {
        if ($this->request->isAJAX()) {
            $data = $this->jabatanModel->find($id);
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
                'nama_jabatan' => 'required|is_unique[jabatan.nama_jabatan,id,{id}]',
            ];

            if (!$this->validate($rules)) {
                return $this->fail($validation->getErrors());
            }

            $id = $this->request->getPost('id');
            $data = [
                'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            ];
            
            if (empty($id)) { // Jika ID kosong, berarti data baru
                $this->jabatanModel->insert($data);
            } else { // Jika ID ada, berarti update data
                $this->jabatanModel->update($id, $data);
            }

            return $this->respondCreated(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        }
    }

    // Method untuk menghapus data
    public function ajax_delete($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->jabatanModel->delete($id)) {
                return $this->respondDeleted(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
            }
            return $this->fail('Gagal menghapus data.');
        }
    }
}