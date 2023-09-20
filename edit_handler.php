<?php
session_start();

require_once 'function.php';


$userid = $_POST['userid'];
$name = $_POST['name'];
$work_place = $_POST['work_place'];
$phone_number = $_POST['phone_number']; 
$address = $_POST['address'];
$emailfor = $_POST['emailfor'];


edit_user_info($userid,$name,$work_place,$phone_number,$address,$emailfor);

if(edit_user_info($userid,$name,$work_place,$phone_number,$address,$emailfor))
    {
        set_flash_message('success','Профиль успешно обновлен');

    $pdo = new PDO ("mysql:host=localhost;dbname=projectlvl1;", "root","");
    $sql = "UPDATE register_table SET email = '$emailfor' WHERE register_table.id = $userid;";                    
    $stmt = $pdo ->prepare($sql);
 redirect_to('users.php');
    }





?>