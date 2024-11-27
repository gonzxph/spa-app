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
        echo json_encode([
            "status"=>"exist",
            "message" => "Email already exist.",
            "redirect" => "signup" // Name of the page to load
        ]);
        exit;
    }

    $isAdded = $userModel->create($firstname, $lastname, $email, $hashPassword);

    if($isAdded){
        echo json_encode([
            "status"=>"success",
            "message" => "User created successfully!",
            "redirect" => "login" // Name of the page to load
        ]);
    }else{
        echo json_encode([
            "status" => "error",
            "message" => "Failed to create user. Please try again.",
            "redirect" => "signup" // Reload signup form
        ]);
    }

}


?>