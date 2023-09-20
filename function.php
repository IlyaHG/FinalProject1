<?php 

require 'Db.php';

/* Проверка пользователя по почте*/

function check_user($email){
$pdo = new PDO ("mysql:host=localhost;dbname=projectlvl1;", "root","");
$sql = "SELECT * FROM register_table WHERE email=:email";
$stmt = $pdo -> prepare($sql);
$stmt-> execute(['email'=>$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC); 
return $user;

}

/* Установка флеш сообщения*/

function set_flash_message($name,$message){
    $_SESSION[$name] = $message;
}


/* Добавление пользователя */

function add_user($email,$password)
{
    if(!empty($email) && (!empty($password))) {
global $db;
$sql = "INSERT INTO register_table (email,password,role) VALUES (:email,:password,:role)";
$stmt = $db ->prepare($sql);
$user = $stmt->execute(['email'=>$email,
                        'password'=>password_hash($password, PASSWORD_DEFAULT),
                        'role' => "user"
                       ]);
return $db->lastInsertId();
}
    return false;
}


function setUserInformation($userid,$name,$work_place,$phone_number,$address,$status_default,$avatar_default,$vk_default,$telegram_default,$instagram_default,$emailfor){
    global $db;
    $sql = "INSERT INTO information_users (id,name,work_place,phone_number,address,status,avatar,vk, telegram,instagram,email) 
                    VALUES   (:id,:name,:work_place,:phone_number,:address,:status,:avatar,:vk, :telegram,:instagram,:email)";
    $stmt = $db ->prepare($sql);
    $user = $stmt->execute(['id'=>$userid,
                            'name'=>$name,
                            'work_place'=>$work_place,
                            'phone_number' => $phone_number,
                            'address' =>$address,
                            'status' =>$status_default,
                            'avatar' => $avatar_default,
                            "vk" => $vk_default,
                            'telegram' => $telegram_default,
                            'instagram' => $instagram_default,
                            'email' => $emailfor
                            
                            
    ]);
    return true;
    }





/* Перевести на страницу*/

function redirect_to($path){
    header('Location: /'.$path);
}

/* Вывод флеш сообщения*/

function display_flash_message($name){
    if(isset($_SESSION[$name])){
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";

    unset($_SESSION[$name]);
    }
}

/* Функция входа на сайт*/

function login($email,$password){
    $email = $_POST['email'];
$password = $_POST['password'];

$user = check_user($email);

var_dump($user);



if(empty($user)){
   set_flash_message("danger", "Неверный email");
    redirect_to("page_login.php");
    exit;
}

if(!empty($user)){

if(!password_verify($password, $user['password'])){
   set_flash_message("danger", "Неверный пароль");
   var_dump(password_verify($password,$user['password']));
    #redirect_to("page_login.php");
    exit;
}
}
 
$_SESSION['user'] = ["email" =>$user['email'], "id" => $user['id'],"role" => $user['role']];

};
/* Функция выхода с сайта*/

function log_out(){
    unset($_SESSION['user']);
redirect_to('page_login.php');
}

/* Проверка зарегистрирован ли пользователь*/

function is_logged_in() {
    if(isset($_SESSION['user'])) {
        return true;
    }else{
        return false;
    }
}

/* Проверка не зарегистрирован ли пользователь*/

function is_not_logged_in(){
    return !is_logged_in();   
}

/* Вывод пользователй*/

function get_users(){
    global $db;
    $sql = "SELECT * FROM information_users";
    $stmt = $db -> prepare($sql);
    $stmt -> execute();
    return $stmt ->fetchAll(PDO::FETCH_ASSOC);
}

/* Вывод зарегистрированного пользователя в сессию*/

function get_authenticated_user(){
    if(is_logged_in()){
        return $_SESSION['user'];
    }else{
        return false;
    }
}

/* Проверка является ли пользователь админом */

function is_admin(){   
    if(is_logged_in()) {
        if($_SESSION['user']['role']==="admin") {
            return true;
        }else{
            return false;
        }
    }
}

/*
/*
! Проверка является ли зарегистрированный пользователь, выбранным пользователем  */

function is_equal($user, $current_user){
    if($user['id'] == $current_user['id'])  {
        return true;
    }else{
        return false;
    }
}


/*
/*Валидация почты, для проверки при создании через
        !Добавить  на create_user.php*/
function validate_email (){
    if (isset($_POST['email'])) {$email = $_POST['email'];} else {$email = '';}
$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
    return true;}
    else{
        return false;
    }
}





function uniavatar($avatar_name,$tmp_name){
    $result = pathinfo($avatar_name);
   $avatar_name = uniqid(). ".". $result['extension'];
   move_uploaded_file($tmp_name,'avatars/'.$avatar_name);
   return $avatar_name;
}
function upload_avatar($avatar_name,$tmp_name,$userid){
   $result = pathinfo($avatar_name);
   $avatar_name = uniqid(). ".". $result['extension'];
   move_uploaded_file($tmp_name,'avatars/'.$avatar_name);

global $db;
$sql = "UPDATE information_users SET avatar = '$avatar_name' WHERE information_users.id = $userid";
$stmt =  $db->prepare($sql);
$stmt -> execute();
return true;
}

function is_author($logged_user_id, $edit_user_id) {
    if($logged_user_id == $edit_user_id){
        return true;
    }else{
        return false;
    }
}

function edit_user_id (){
    foreach($_GET as $key => $value)
    return $value;
}

function get_user_by_id ($id){
    global $db;
    $sql = "SELECT * FROM information_users WHERE information_users.id = $id";
    $stmt = $db->prepare($sql);
    $stmt -> execute();
    return $stmt -> fetch(PDO::FETCH_ASSOC);

   
}

function edit_user_info($userid,$name,$work_place,$phone_number,$address,$email){
    global $db;
    $sql = "UPDATE information_users SET name = '$name', work_place = '$work_place', phone_number = '$phone_number',address = '$address',email ='$email' WHERE information_users.id = $userid;";                    
    $stmt = $db ->prepare($sql);
    return $stmt ->execute();
}
            
function transfer_the_mail($id){
    global $db;
    $sql = "SELECT * FROM register_table WHERE register_table.id = $id";
    $stmt = $db->prepare($sql);
    $stmt -> execute();
    $user_mail = $stmt -> fetch(PDO::FETCH_ASSOC);
    $mail = $user_mail['email'];
    return $mail;
}

function get_user_by_id2 ($id){
    global $db;
    $sql = "SELECT * FROM register_table WHERE register_table.id = $id";
    $stmt = $db->prepare($sql);
    $stmt -> execute();
    return $stmt -> fetch(PDO::FETCH_ASSOC);
}


function edit_credentials($userid, $email, $password){
    $newpassword = password_hash($password, PASSWORD_DEFAULT);
    global $db;
    $sql = "UPDATE register_table SET email = '$email', password = '$newpassword' WHERE register_table.id = $userid";                   
    $stmt = $db ->prepare($sql);
    $stmt ->execute();
    return true;
}


function set_status($userid,$newstatus){
    global $db;
    $sql = "UPDATE information_users SET status = '$newstatus' WHERE information_users.id = $userid";
    $stmt = $db->prepare($sql);
    return $stmt->execute();
}
function has_avatar($userid){
    global $db;
    $sql = "SELECT avatar FROM information_users  WHERE information_users.id = $userid";
    $stmt = $db->prepare($sql);
    $stmt -> execute();
    return true;
}

function delete_user ($userid){
    global $db;
    $sql = "DELETE FROM information_users  WHERE information_users.id = $userid";
    $stmt = $db->prepare($sql);
    $stmt -> execute();

    $sql = "DELETE FROM register_table WHERE register_table.id =$userid;";
    $stmt = $db->prepare($sql);
    $stmt -> execute();

}

function select_last_id(){
    global $db;
    $sql = "SELECT MAX(id) FROM register_table;";
    $stmt = $db -> prepare($sql);
    $userid = $stmt -> execute();
    $userid = $stmt -> fetch(PDO::FETCH_ASSOC);
    return $userid;
}