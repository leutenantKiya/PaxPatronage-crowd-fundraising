<?php
class Connection
{
    private $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $db_name = $_ENV["DB_NAME"];
        $host = $_ENV["DB_HOST"];
        $user = $_ENV["DB_USER"];
        $pass = $_ENV["DB_PASS"];

        // make conn
        $this->conn = new mysqli($host, $user, $pass, $db_name);
        // check conn 
        if (!$this->conn || $this->conn->connect_error){
            die("Gagal ". $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function getAllKampanye(){
        // Home page: tampilkan semua kampanye yang belum selesai (sesuai requirements PDF).
        // JOIN users -> ambil nama penyelenggara untuk ditampilkan di card.
        // ORDER BY: deadline terdekat dulu, lalu target paling kecil (bonus rubrik).
        $sql = "SELECT k.id, k.nama_kampanye, k.jenis_kampanye, k.target_kampanye,
                       k.dana_terkumpul, k.tanggal_dimulai, k.tanggal_berakhir,
                       k.deskripsi, k.path_gambar, k.user_id,
                       k.alamat_jalan, k.kota, k.provinsi,
                       u.name AS nama_penyelenggara
                FROM kampanye k
                INNER JOIN users u ON u.id = k.user_id
                WHERE k.tanggal_berakhir >= NOW()
                ORDER BY k.tanggal_berakhir ASC, k.target_kampanye ASC";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function getKampanye($id){
        $sql = "SELECT * FROM kampanye WHERE user_id = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt); 
    }

    public function tambahKampanye($nama_kampanye, $jenis_kampanye, $target_dana, $tanggal_dimulai, $tanggal_berakhir, $deskripsi, $path_foto, $user_id, $alamat_jalan, $kota, $provinsi){
        // butuh : nama_kampanye, jenis_kampanye, target_dana (target_kampanye), tanggal_dimulai, tanggal_berakhir, deskripsi, path_foto, user_id, alamat_jalan, kota, provinsi
        $sql = "INSERT INTO kampanye (nama_kampanye, jenis_kampanye, target_kampanye, tanggal_dimulai, tanggal_berakhir, deskripsi, path_gambar, user_id, alamat_jalan, kota, provinsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdssssisss", $nama_kampanye, $jenis_kampanye, $target_dana, $tanggal_dimulai, $tanggal_berakhir, $deskripsi, $path_foto, $user_id, $alamat_jalan, $kota, $provinsi);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt) > 0;
    }

    public function hapusKampanye($kampanye_id, $user_id){
        $sql = "DELETE FROM kampanye WHERE id = ? AND user_id = ? AND COALESCE(dana_terkumpul, 0) < 10000";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $kampanye_id, $user_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt) > 0;
    }

    public function getKampanyeById($kampanye_id){
        $sql = "SELECT k.*, u.name AS nama_penyelenggara, u.phone AS no_telp
                FROM kampanye k
                INNER JOIN users u ON u.id = k.user_id
                WHERE k.id = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $kampanye_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function getKampanyeByIdAndUser($kampanye_id, $user_id){
        $sql = "SELECT * FROM kampanye WHERE id = ? AND user_id = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $kampanye_id, $user_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt); 
    }

    public function updateKampanye($kampanye_id, $nama_kampanye, $jenis_kampanye, $target_dana, $tanggal_dimulai, $tanggal_berakhir, $deskripsi, $path_gambar, $user_id, $alamat_jalan, $kota, $provinsi){
        $sql = "UPDATE kampanye SET nama_kampanye = ?, jenis_kampanye = ?, target_kampanye = ?, tanggal_dimulai = ?, tanggal_berakhir = ?, deskripsi = ?, path_gambar = ?, alamat_jalan = ?, kota = ?, provinsi = ? WHERE id = ? AND user_id = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdsssssssii", $nama_kampanye, $jenis_kampanye, $target_dana, $tanggal_dimulai, $tanggal_berakhir, $deskripsi, $path_gambar, $alamat_jalan, $kota, $provinsi, $kampanye_id, $user_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt);
    }

    public function tambahDonasi($kampanye_id, $user_id, $name_hidden, $amount, $metode_bayar, $pesan, $bukti_bayar){
        $sql = "INSERT INTO donasi (kampanye_id, user_id, name_hidden, amount, metode_bayar, pesan, bukti, created_at) VALUES (?,?,?,?,?,?,?, NOW())";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiidsss", $kampanye_id, $user_id, $name_hidden, $amount, $metode_bayar, $pesan, $bukti_bayar);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt);
    }

    private function getDonasiByKampanyeWithStatus($kampanye_id, $owner_user_id, $status, $order_dir){
        $order_dir = ($order_dir === "ASC") ? "ASC" : "DESC";
        $sql = "SELECT d.id_donasi, d.kampanye_id, d.user_id, d.name_hidden,
                       d.amount, d.metode_bayar, d.pesan, d.bukti, d.status, d.created_at,
                       CASE WHEN d.name_hidden = 1 THEN 'Anonim' ELSE u.name END AS nama_donatur,
                       u.email AS email_donatur,
                       u.phone AS phone_donatur
                FROM donasi d
                INNER JOIN users u ON u.id = d.user_id
                INNER JOIN kampanye k ON k.id = d.kampanye_id
                WHERE d.kampanye_id = ? AND d.status = ? AND k.user_id = ?
                ORDER BY d.created_at $order_dir, d.id_donasi $order_dir";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isi", $kampanye_id, $status, $owner_user_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function getDonasiPendingByKampanye($kampanye_id, $owner_user_id){
        // Antrian verifikasi: FIFO, yang submit duluan diverifikasi duluan (ASC).
        return $this->getDonasiByKampanyeWithStatus($kampanye_id, $owner_user_id, "pending", "ASC");
    }

    public function getDonasiVerifiedByKampanye($kampanye_id, $owner_user_id){
        // Daftar donatur sukses: terbaru di atas (DESC, pattern crowdfunding standar).
        return $this->getDonasiByKampanyeWithStatus($kampanye_id, $owner_user_id, "verified", "DESC");
    }

    public function getDonasiRejectedByKampanye($kampanye_id, $owner_user_id){
        // Donasi yang ditolak: terbaru di atas.
        return $this->getDonasiByKampanyeWithStatus($kampanye_id, $owner_user_id, "rejected", "DESC");
    }

    public function verifikasiDonasi($id_donasi, $owner_user_id){
        // whewn update stat to verified simultenously add to amount
        // Multi-table UPDATE = atomic, tidak butuh transaction eksplisit.
        $sql = "UPDATE donasi d
                INNER JOIN kampanye k ON k.id = d.kampanye_id
                SET d.status = 'verified',
                    k.dana_terkumpul = COALESCE(k.dana_terkumpul, 0) + d.amount
                WHERE d.id_donasi = ? AND d.status = 'pending' AND k.user_id = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_donasi, $owner_user_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt) > 0;
    }

    public function tolakDonasi($id_donasi, $owner_user_id){
        // Reject: cuma update status='rejected'. Dana_terkumpul tidak diutak-atik
        // (donasi pending memang belum pernah masuk hitungan).
        // Guard sama: hanya pending yang bisa direject (idempotent), hanya pemilik kampanye.
        $sql = "UPDATE donasi d
                INNER JOIN kampanye k ON k.id = d.kampanye_id
                SET d.status = 'rejected'
                WHERE d.id_donasi = ? AND d.status = 'pending' AND k.user_id = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_donasi, $owner_user_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt) > 0;
    }

    public function tambahRekening($id_kampanye, $nama_bank, $nomor_rekening){
        $sql = "INSERT INTO rekening_kampanye (id_kampanye, nama_bank, nomor_rekening) VALUES (?, ?, ?)";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $id_kampanye, $nama_bank, $nomor_rekening);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt) > 0;
    }

    public function getRekeningByKampanye($id_kampanye){
        $sql = "SELECT * FROM rekening_kampanye WHERE id_kampanye = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_kampanye);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function updateRekening($id_kampanye, $nama_bank, $nomor_rekening){
        // Cek apakah sudah ada rekening untuk kampanye ini
        $existing = $this->getRekeningByKampanye($id_kampanye);
        if (mysqli_num_rows($existing) > 0) {
            $sql = "UPDATE rekening_kampanye SET nama_bank = ?, nomor_rekening = ? WHERE id_kampanye = ?";
            $conn = $this->getConnection();
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $nama_bank, $nomor_rekening, $id_kampanye);
            mysqli_stmt_execute($stmt);
            return mysqli_stmt_affected_rows($stmt);
        } else {
            return $this->tambahRekening($id_kampanye, $nama_bank, $nomor_rekening);
        }
    }

    public function hapusRekening($id_rekening){
        $sql = "DELETE FROM rekening_kampanye WHERE id_rekening = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_rekening);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt) > 0;
    }
}

// $result = mysqli_query($conn, "Select * from users;");
// if(mysqli_num_rows($result) > 0){
//     while($row = mysqli_fetch_assoc($result)){
//         echo "id".$row["user_type"];
//     }
// }
?>
