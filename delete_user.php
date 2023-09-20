<?php 

session_start();
require_once "function.php";

//if(is_not_logged_in()){
   // redirect_to("page_login.php");
//}

$logged_user_id = $_SESSION['user']['id'];

$edit_user_id = $_GET['userid'];



if(!is_author($logged_user_id,$edit_user_id) && !is_admin()) {
    set_flash_message('danger','Можно удалить только свой профиль');
    redirect_to('users.php');
    exit;
}

var_dump($edit_user_id);


delete_user($edit_user_id);

if(is_admin()){
    set_flash_message('success','Пользователь удален');
    redirect_to('users.php');
}else{
    set_flash_message('danger','Ваш аккаунт удален');
    redirect_to('page_login.php');
}

//var_dump(123);