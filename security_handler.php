<?php 
session_start();
require_once 'function.php';

if(is_not_logged_in()){
    redirect_to("page_login.php");
    exit;
}




var_dump($_POST);

$newemail = $_POST['newemail'];
$newpass = $_POST['newpass'];
$newpass2 = $_POST['newpass2'];
$userid = $_POST['userid'];
var_dump($_POST['userid']);






$check = check_user($newemail);

if($check){
    set_flash_message('danger','Эта почта уже занята');
    redirect_to('security.php');
    exit;
}
 
if($newpass!=$newpass2){
    set_flash_message('danger', "Пароли не совпадают");
    redirect_to('security.php');
    exit;
}

edit_credentials($userid,$newemail,$newpass);
set_flash_message("success", "Данные успешно обновлены");
redirect_to('users.php')
#var_dump($email);
?> 