<?php 

session_start();
require_once "function.php";

if(is_not_logged_in()){
    redirect_to("page_login.php");
}


$logged_user_id = $_SESSION['user']['id'];

$edit_user_id = $_POST['userid'];

if(!is_author($logged_user_id,$edit_user_id) && !is_admin()) {
    set_flash_message('danger','Можно редактировать только свой профиль');
    redirect_to('users.php');
    exit;
}



$userid = $_POST['userid'];

$old_status = $_POST['status'];

$old_status =$_POST['status'];
if ($old_status == "Онлайн") {
    $newstatus = "success";
} elseif ($old_status == "Отошел") {
    $newstatus = "warning";
} else {
    $newstatus ='danger' ;
}

set_status($userid,$newstatus);
set_flash_message('success',"Ваш статус обновлен");
redirect_to('users.php');