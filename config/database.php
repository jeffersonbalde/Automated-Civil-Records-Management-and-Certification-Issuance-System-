<?php

class Database
{

    // FOR LOCAL
    // private $host = "localhost";
    // private $db_name = "civildb";
    // private $username = "root";
    // private $password = "";
    // public $conn;

    // public function getConnection()
    // {
    //     $this->conn = null;
    //     try {
    //         $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
    //         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //         return $this->conn;
    //     } catch (PDOException $e) {
    //         echo "Connection Error: " . $e->getMessage();
    //         return null;
    //     }
    // }

    // FOR PRODUCTION
    private $host = getenv("DB_HOST") ?: "localhost";
    private $db_name = getenv("DB_NAME") ?: "civildb";
    private $username = getenv("DB_USERNAME") ?: "doadmin";
    private $password = getenv("DB_PASSWORD") ?: "";
    private $port = getenv("DB_PORT") ?: "25060";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";sslmode=require";
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
            return null;
        }
    }
}

// Create database instance
$database = new Database();
$conn = $database->getConnection();
