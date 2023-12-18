<?php
session_start();
require_once 'class.user.php';
$user = new USER();

if(!$user->is_logged_in())
{
    setcookie("cokkiemail","",time()-(86400*30));
    setcookie("cokkiepass","",time()-(86400*30));
 $user->redirect('index');
}

if($user->is_logged_in()!="")
{
    setcookie("cokkiemail","",time()-(86400*30));
    setcookie("cokkiepass","",time()-(86400*30));
 $user->logout(); 
 $user->redirect('index');
}
?>