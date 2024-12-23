<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "data_akun";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error) {
            die("Koneksi ke database gagal: " . $this->conn->connect_error);
        }
    }

    public function insertData($name, $phone, $ip_address, $browser) {
        $sql = "INSERT INTO spesifikasi (Nama, Nomor_HP, IP_Address, Browser) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $phone, $ip_address, $browser);
        $stmt->execute();
    }

    public function getData() {
        $query = "SELECT No, Nama, Nomor_HP, IP_Address, Browser FROM spesifikasi";
        return $this->conn->query($query);
    }
}
?>