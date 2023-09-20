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




$avatar_name = $_FILES['avatar']['name'];
$avatar_tmp_name = $_FILES['avatar']['tmp_name'];

var_dump($avatar_name);
var_dump($avatar_tmp_name);



upload_avatar($avatar_name,$avatar_tmp_name,$edit_user_id);

set_flash_message('success','Аватар успешно обновлен');
redirect_to('users.php');

