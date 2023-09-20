<?php
session_start();
require_once "function.php";

var_dump($_POST);


$email = $_POST['email'];
$password = $_POST['password'];

$old_status =$_POST['status'];
if ($old_status == "Онлайн") {
    $newstatus = "success";
} elseif ($old_status == "Отошел") {
    $newstatus = "warning";
} else {
    $newstatus ='danger' ;
}

$avatar = $_FILES['avatar']['name'];
$avatar_tmp_name = $_FILES['avatar']['tmp_name'];
$avatar_name = uniavatar($avatar,$avatar_tmp_name);


$name = $_POST['name'];
$work_place = $_POST['work_place'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];
$status_default = $newstatus;
$avatar_default = "avatar2";
$vk_default = $_POST['vk'];
$telegram_default = $_POST['telegram'];
$instagram_default = $_POST['instagram'];
$emailfor = $_POST["emailfor"];



upload_avatar($avatar_name,$userid,$avatar_tmp_name);

#var_dump($email);

$validate_email = validate_email();
#var_dump($validate_email);

if ($validate_email == false) {
    set_flash_message("null_email", "Для регистрации необходима почта");
    redirect_to("create_user.php");
    exit;
}


$check_user = check_user($email);

//var_dump($check_user);

if (!empty($check_user)) {
    set_flash_message('warning', "Пользователь с таким электронным адресом уже существует");
    redirect_to("create_user.php");
    exit;
}

// Здесь мне нужен запрос чтобы вытянуть айди у созданного пользователя

$userid=add_user($email,$password);

setUserInformation($userid,$name,$work_place,$phone_number,$address,$status_default,$avatar_name,$vk_default,$telegram_default,$instagram_default,$emailfor);
redirect_to('users.php');

?>