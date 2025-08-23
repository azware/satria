<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel; // [PENTING] Impor UserModel

abstract class BaseController extends Controller
{
    protected $helpers = [];
    protected $session;

    /**
     * @var \CodeIgniter\HTTP\IncomingRequest|\CodeIgniter\HTTP\CLIRequest
     */
    protected $request;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        $this->session = \Config\Services::session();
        $this->setDatabaseUser();
    }

    /**
     * Method untuk mengatur variabel sesi di level database.
     * Versi baru ini menggunakan koneksi dari model untuk stabilitas.
     *
     * @return void
     */
    protected function setDatabaseUser(): void
    {
        try {
            // [PERBAIKAN KUNCI]
            // 1. Buat instance dari UserModel (atau model apa pun yang sudah ada).
            //    Saat model dibuat, CodeIgniter secara otomatis akan memberinya
            //    koneksi database yang valid.
            $userModel = new UserModel();

            // 2. "Pinjam" objek koneksi database dari model tersebut.
            $db = $userModel->db;

            // 3. Ambil user_id dari sesi.
            $loggedInUserId = $this->session->get('user_id');

            // 4. Jalankan query seperti biasa.
            if ($loggedInUserId) {
                $db->query("SET @current_user_id = ?", [$loggedInUserId]);
            } else {
                $db->query("SET @current_user_id = NULL");
            }
        } catch (\Throwable $e) {
            // Jika terjadi error apa pun (misalnya, koneksi DB tetap gagal),
            // catat ke log agar tidak menyebabkan halaman putih/crash.
            log_message('error', 'Gagal mengatur database user: ' . $e->getMessage());
        }
    }
}