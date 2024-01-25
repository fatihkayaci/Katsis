<?php

require_once 'dbconfig.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class USER
{ 

 private $conn;
 
 public function __construct()
 {
  $database = new Database();
  $db = $database->dbConnection();
  $this->conn = $db;
    }
 
 public function runQuery($sql)
 {
  $stmt = $this->conn->prepare($sql);
  return $stmt;
 }
 
 public function lasdID()
 {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
 }
 
 public function register($uname,$email,$upass,$code,$confirmPassword)
 {
    if($upass == $confirmPassword){
      try
      {       
       $password = base64_encode($upass);
       $stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode) 
                                                    VALUES(:user_name, :user_mail, :user_pass, :active_code)");
       $stmt->bindparam(":user_name",$uname);
       $stmt->bindparam(":user_mail",$email);
       $stmt->bindparam(":user_pass",$password);
       $stmt->bindparam(":active_code",$code);
       $stmt->execute(); 
       return $stmt;
      }
      catch(PDOException $ex)
      {
       echo $ex->getMessage();
      }
    }else{
      return false;
    }
 }
 
 public function login($email,$upass)
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
   $stmt->execute(array(":email_id"=>$email));
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

   if($stmt->rowCount() == 1)
   {
    if($userRow['userStatus']=="Y")
    {
     if($userRow['userPass']==base64_encode($upass))
     {
      $_SESSION['userSession'] = $userRow['userID'];
      $_SESSION['rol'] = $userRow['rol'];
      return true;
     }
     else
     {
      header("Location: index.php?error");
      exit;
     }
    }
    else
    {
     header("Location: index.php?inactive");
     exit;
    } 
   }
   else
   {
    header("Location: index.php?error");
    exit;
   }
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }
 
 
 public function is_logged_in()
 {
  if(isset($_SESSION['userSession']))
  {
   return true;
  }
 }
 
 public function redirect($url)
 {
  header("Location: $url");
 }
 
 public function logout()
 {
  session_destroy();
  $_SESSION['userSession'] = false;
 }
 
 function send_mail($email,$message,$subject)
 {      

 
//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

  $mail = new PHPMailer();
  $mail->IsSMTP(); 
  $mail->SMTPDebug  = 0;                     
  $mail->SMTPAuth   = true;                  
  $mail->SMTPSecure = "ssl";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port       = 465;             
  $mail->AddAddress($email);
  $mail->Username="fatihkayaci5334@gmail.com";  
  $mail->Password="zmqvgxixuapwkudd";            
  $mail->SetFrom('fatihkayaci5334@gmail.com','Katsis');
  $mail->AddReplyTo("fatihkayaci5334@gmail.com","Katsis");
  $mail->Subject    = $subject;
  $mail->MsgHTML($message);
  $mail->CharSet    = 'utf-8';
  $mail->Send();
 } 
}