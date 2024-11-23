<?php

require_once '../includes/db.php';
require_once '../models/User.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $hashPassword = password_hash($password, PASSWORD_BCRYPT);

    $userModel = new User($db);

    if($userModel->existingEmail($email)){
        echo 'Already exist';
    }else{
        echo 'Not found email';
    }

    $isAdded = $userModel->create($firstname, $lastname, $email, $hashPassword);

    if($isAdded){
        echo 'User created successfully';
    }else{
        echo 'Not created';
    }

}


?>