<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\DepartemenModel;
use App\Models\JabatanModel;
use CodeIgniter\API\ResponseTrait; // Tambahkan ini

class Pegawai extends BaseController
{
    use ResponseTrait; // Tambahkan ini

    protected $pegawaiModel;
    protected $departemenModel;
    protected $jabatanModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->departemenModel = new DepartemenModel();
        $this->jabatanModel = new JabatanModel();
    }

    // Menampilkan halaman utama (partial view)
    public function index()
    {
        $data['departemen'] = $this->departemenModel->findAll();
        $data['jabatan'] = $this->jabatanModel->findAll();
        return view('pegawai/index', $data);
    }

    // Mengambil data untuk DataTables (JSON)
    public function ajax_list()
    {
        if ($this->request->isAJAX()) {
            $data = $this->pegawaiModel->getPegawaiWithDetails();
            return $this->response->setJSON(['data' => $data]);
        }
    }

    // Menambah atau mengedit data (JSON response)
    public function ajax_save()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            
            // Aturan validasi
            $rules = [
                'nip' => 'required|is_unique[pegawai.nip,id,{id}]',
                'nama_lengkap' => 'required',
                'email' => 'required|valid_email|is_unique[pegawai.email,id,{id}]',
            ];

            if (!$this->validate($rules)) {
                return $this->fail($validation->getErrors());
            }

            $id = $this->request->getPost('id');
            $data = [
                'nip' => $this->request->getPost('nip'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'email' => $this->request->getPost('email'),
                'no_telp' => $this->request->getPost('no_telp'),
                'alamat' => $this->request->getPost('alamat'),
                'departemen_id' => $this->request->getPost('departemen_id'),
                'jabatan_id' => $this->request->getPost('jabatan_id'),
            ];
            
            if (empty($id)) { // Insert
                $this->pegawaiModel->insert($data);
            } else { // Update
                $this->pegawaiModel->update($id, $data);
            }

            return $this->respondCreated(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        }
    }

    // Mengambil data tunggal untuk form edit (JSON)
    public function ajax_edit($id)
    {
        if ($this->request->isAJAX()) {
            $data = $this->pegawaiModel->find($id);
            return $this->respond($data);
        }
    }

    // Menghapus data (JSON response)
    public function ajax_delete($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->pegawaiModel->delete($id)) {
                return $this->respondDeleted(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
            }
            return $this->fail('Gagal menghapus data.');
        }
    }
}