<?php 


session_start();

require "function.php";

#записываем данные из формы в переменные
$email = $_POST['email'];
$password = $_POST['password'];
 

#проверяем что получили данные
var_dump($email);

$user = check_user($email);


if(!empty($user)){
   set_flash_message('danger',"Этот эл. адрес уже занят другим пользователем.");
    redirect_to('page_register.php');
   
exit;
}

$user = add_user($email,$password);
set_flash_message('success',"Регистрация успешна");


$id = select_last_id();

$userid = $id['MAX(id)'];


$name = "noname";
$work_place = "no info";
$phone_number = "no info ";
$address = "no info";
$status_default = "success";
$avatar_default = "no avatar";
$vk_default = "vk_link";
$telegram_default = "tg_link";
$instagram_default = "insta_link";


setUserInformation($userid,$name,$work_place,$phone_number,$address,$status_default,$avatar_default,$vk_default,$telegram_default,$instagram_default,$email);

redirect_to('page_login.php');




?> 