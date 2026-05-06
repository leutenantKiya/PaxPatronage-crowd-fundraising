<?php
class Connection
{
    private $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $host = $_ENV["DB_HOST"];
        $db_name = $_ENV["DB_NAME"];
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
}

// $result = mysqli_query($conn, "Select * from users;");
// if(mysqli_num_rows($result) > 0){
//     while($row = mysqli_fetch_assoc($result)){
//         echo "id".$row["user_type"];
//     }
// }
?>
