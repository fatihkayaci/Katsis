<?php
class Database
{
     
    private $host = "45.10.151.41";
    private $db_name = "katsis2";
    private $username = "roott";
    private $password = "PW2jnY5T8v6eHWRc";
    public $conn;
     
    public function dbConnection()
 {
     
     $this->conn = null;    
        try
  {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
   $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }
  catch(PDOException $exception)
  {
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
}
?>