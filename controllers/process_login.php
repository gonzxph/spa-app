<?php

require_once '../includes/db.php';
require_once '../models/User.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userModel = new User($db);

    $user = $userModel->verifyUser($email, $password);
    header('Content-Type: application/json');
    if($user){
        
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_email'] = $user['user_email'];
        echo json_encode([
            "status"=>"success",
            "message" => "Login successful!",
            "redirect" => "dashboard" // Redirect to the dashboard page
        ]);

    }else{
        echo json_encode([
            "status"=>"invalidPass",
            "message"=>"Invalid email or password.",
        ]);
    }
}


?>