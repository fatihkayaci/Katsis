<?php
class Database
{
     
    private $host = "185.92.2.129";
    private $db_name = "katsis";
    private $username = "roott";
    private $password = "LnHgM5o-0WtltVCH";
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
