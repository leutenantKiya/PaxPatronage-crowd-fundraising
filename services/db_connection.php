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

    public function getKampanye($id){
        $sql = "SELECT * FROM kampanye WHERE user_id = ?";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt); 
    }

    public function tambahKampanye($nama_kampanye, $jenis_kampanye, $target_dana, $tanggal_dimulai, $tanggal_berakhir, $deskripsi, $path_foto, $user_id){
        // butuh : nama_kampanye, jenis_kampanye, target_dana (target_kampanye), tanggal_dimulai, tanggal_berakhir, deskripsi, path_foto, user_id
        $sql = "INSERT INTO kampanye (nama_kampanye, jenis_kampanye, target_kampanye, tanggal_dimulai, tanggal_berakhir, deskripsi, path_gambar, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $conn = $this->getConnection();
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdssssi", $nama_kampanye, $jenis_kampanye, $target_dana, $tanggal_dimulai, $tanggal_berakhir, $deskripsi, $path_foto, $user_id);
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
