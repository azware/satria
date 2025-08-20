<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest; // [BARU] Tambahkan ini
use CodeIgniter\HTTP\IncomingRequest; // [BARU] Ganti RequestInterface dengan kelas yang lebih spesifik
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // [BARU] Deklarasikan properti yang akan kita gunakan
    protected $session;
    protected $db;

    /**
     * @param IncomingRequest|CLIRequest $request
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        
        // [BARU] Inisialisasi service session dan koneksi database
        // Cara ini lebih disukai daripada memanggilnya secara global.
        $this->session = service('session');
        $this->db = service('database');

        // [BARU] Jalankan fungsi untuk mengatur variabel user di database
        // Kita letakkan di sini agar dieksekusi pada setiap request.
        $this->setDatabaseUser();
    }

    /**
     * [BARU] Method untuk mengatur variabel sesi di level database.
     * Dibuat 'protected' agar hanya bisa diakses oleh controller ini dan turunannya.
     *
     * @return void
     */
    protected function setDatabaseUser(): void
    {
        // Cek apakah ada 'user_id' di dalam data sesi. 
        // Gantilah 'user_id' dengan nama key sesi Anda yang sebenarnya saat login.
        $loggedInUserId = $this->session->get('user_id');

        if ($loggedInUserId) {
            // Jika ada user yang login, kirim perintah SET ke database
            $this->db->query("SET @current_user_id = ?", [$loggedInUserId]);
        } else {
            // Jika tidak ada user yang login (misalnya, cron job atau akses publik),
            // atur variabelnya menjadi NULL.
            $this->db->query("SET @current_user_id = NULL");
        }
    }
}