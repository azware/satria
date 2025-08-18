<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class TestDB extends Controller
{
    public function index()
    {
        try {
            $db = Database::connect();

            if ($db) {
                echo "✅ Koneksi database berhasil!<br>";
                echo "Versi MySQL: " . $db->getVersion();
            } else {
                $error = mysqli_connect_error();
                echo "❌ Gagal koneksi database.<br>";
                echo "Error MySQL: " . $error. $db->getConnection();
            }
        } catch (\Throwable $e) {
            echo "❌ Gagal koneksi database.<br>";
            echo "Pesan error: " . $e->getMessage() . "<br>";
            echo "File: " . $e->getFile() . "<br>";
            echo "Baris: " . $e->getLine();
        }
    }
}
