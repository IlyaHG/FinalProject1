<?php 

session_start();

//var_dump($check_email['password']);
require "function.php";

login($_POST['email'],$_POST['password']);

$id = select_last_id();

$userid = $id['MAX(id)'];
var_dump ($userid);

redirect_to("page_profile.php?userid='$userid'");



//redirect_to('users.php');



?>