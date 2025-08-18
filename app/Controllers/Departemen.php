<?php

namespace App\Controllers;

use App\Models\DepartemenModel;
use CodeIgniter\API\ResponseTrait;

class Departemen extends BaseController
{
    use ResponseTrait;

    protected $departemenModel;

    public function __construct()
    {
        $this->departemenModel = new DepartemenModel();
    }

    // Method untuk menampilkan view utama
    public function index()
    {
        return view('departemen/index');
    }

    // Method untuk mengambil data bagi DataTables
    public function ajax_list()
    {
        if ($this->request->isAJAX()) {
            $data = $this->departemenModel->findAll();
            return $this->response->setJSON(['data' => $data]);
        }
    }

    // Method untuk mengambil data tunggal untuk form edit
    public function ajax_edit($id)
    {
        if ($this->request->isAJAX()) {
            $data = $this->departemenModel->find($id);
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
                'nama_departemen' => 'required|is_unique[departemen.nama_departemen,id,{id}]',
            ];

            if (!$this->validate($rules)) {
                return $this->fail($validation->getErrors());
            }

            $id = $this->request->getPost('id');
            $data = [
                'nama_departemen' => $this->request->getPost('nama_departemen'),
            ];
            
            if (empty($id)) { // Jika ID kosong, berarti data baru
                $this->departemenModel->insert($data);
            } else { // Jika ID ada, berarti update data
                $this->departemenModel->update($id, $data);
            }

            return $this->respondCreated(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        }
    }

    // Method untuk menghapus data
    public function ajax_delete($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->departemenModel->delete($id)) {
                return $this->respondDeleted(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
            }
            return $this->fail('Gagal menghapus data.');
        }
    }
}