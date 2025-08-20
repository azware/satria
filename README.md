# SATRIA - Sistem Informasi Tata Pegawai Terintegrasi

**SATRIA** adalah aplikasi web modern yang dirancang untuk menjadi "ksatria digital" bagi departemen HR. Dibangun dengan filosofi *all-in-one*, SATRIA bertujuan untuk mengelola seluruh siklus hidup kepegawaian—dari rekrutmen hingga pensiun—dalam satu platform yang terintegrasi, efisien, dan aman.

Proyek ini dikembangkan menggunakan **CodeIgniter 4** pada backend dengan pendekatan antarmuka *Single Page Application (SPA-like)* yang responsif di frontend.

---

## ✨ Fitur Utama

SATRIA dirancang secara modular untuk mencakup semua kebutuhan administrasi HR modern.

### Modul Inti (Core)
*   🏢 **Manajemen Organisasi:** Kelola struktur departemen dan jabatan dengan mudah.
*   👤 **Database Pegawai (PIM):** Pusat informasi karyawan yang lengkap dan terstruktur.
*   🔐 **Manajemen Peran & Hak Akses:** Kontrol akses yang fleksibel untuk Admin, HR, Manajer, dan Karyawan.

### Modul Operasional & Pengembangan
*   ⏰ **Manajemen Waktu & Kehadiran:** Absensi, manajemen cuti, izin, dan lembur dengan alur persetujuan.
*   💰 **Penggajian (Payroll):** Perhitungan gaji, PPh 21, BPJS, dan pembuatan slip gaji otomatis.
*   🚀 **Manajemen Kinerja:** Penetapan dan penilaian KPI untuk mendorong pertumbuhan.

### Modul Akuisisi Talenta & Offboarding
*   📄 **Applicant Tracking System (ATS):** Lacak proses rekrutmen dari lamaran hingga penawaran.
*   🚪 **Manajemen Offboarding:** Proses resign dan pensiun yang terstruktur.

### Portal Karyawan
*   🖥️ **Employee Self-Service (ESS):** Portal bagi karyawan untuk mengakses data pribadi, mengajukan cuti, dan melihat slip gaji.

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

*   **Backend:** PHP 8.x, **CodeIgniter 4**
*   **Frontend:** HTML5, CSS3, **Bootstrap 5**, **jQuery**
*   **Database:** MySQL / MariaDB / PostgreSQL
*   **Server:** Apache / Nginx

---

## 🚀 Instalasi & Penyiapan (Lokal)

Ikuti langkah-langkah berikut untuk menjalankan SATRIA di lingkungan development Anda.

1.  **Prasyarat:**
    *   PHP >= 8.0
    *   Composer
    *   Database (MySQL/MariaDB/PostgreSQL)
    *   Git

2.  **Clone Repository:**
    ```bash
    git clone https://URL_REPOSITORY_ANDA/satria.git
    cd satria
    ```

3.  **Instal Dependensi:**
    Jalankan Composer untuk menginstal semua dependensi PHP yang dibutuhkan.
    ```bash
    composer install
    ```

4.  **Konfigurasi Lingkungan:**
    Salin file `env` menjadi `.env` dan sesuaikan konfigurasinya.
    ```bash
    cp env .env
    ```
    Buka file `.env` dan atur variabel berikut:
    ```dotenv
    # Atur baseURL sesuai dengan lingkungan Anda
    app.baseURL = 'http://localhost:8080/'

    # Konfigurasi koneksi database Anda
    database.default.hostname = localhost
    database.default.database = nama_database_satria
    database.default.username = root
    database.default.password =
    database.default.DBDriver = MySQLi
    ```

5.  **Migrasi Database:**
    Impor file SQL skema database ke database yang telah Anda buat. File bisa ditemukan di `database/schema.sql`. (Atau jika Anda menggunakan Migrations, jalankan perintahnya).
    ```bash
    # Contoh menggunakan CLI MySQL
    mysql -u root -p nama_database_satria < database/schema.sql
    ```

6.  **Jalankan Aplikasi:**
    Gunakan server development bawaan CodeIgniter.
    ```bash
    php spark serve
    ```
    Aplikasi Anda sekarang berjalan di [http://localhost:8080](http://localhost:8080).

---

## 🗺️ Roadmap Pengembangan

Proyek ini dikembangkan secara bertahap. Berikut adalah peta jalan utama:

-   [x] **Fase 1: MVP Core** - Modul Inti, Manajemen Waktu & Kehadiran.
-   [ ] **Fase 2: Payroll & ESS** - Modul Penggajian dan Portal Karyawan.
-   [ ] **Fase 3: Talent Lifecycle** - Modul Rekrutmen dan Offboarding.
-   [ ] **Fase 4: Strategic HR** - Modul Manajemen Kinerja dan Dasbor Analitik.

---

## 🤝 Berkontribusi

Kami sangat terbuka untuk kontribusi! Jika Anda ingin membantu mengembangkan SATRIA, silakan Fork repository ini, buat branch baru untuk fitur Anda, dan kirimkan Pull Request.

1.  Fork the Project
2.  Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3.  Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4.  Push to the Branch (`git push origin feature/AmazingFeature`)
5.  Open a Pull Request

---

## 📄 Lisensi

Didistribusikan di bawah Lisensi MIT. Lihat `LICENSE` untuk informasi lebih lanjut.
