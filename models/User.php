<?php

class User{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }


    public function existingEmail($email){
        try{
            
            $sql = "SELECT * FROM user WHERE user_email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }catch(PDOException $e){
            error_log("Error finding user: " . $e->getMessage());
            return false;
        }
    }


    public function create($firstname, $lastname, $email, $password){
        try{
            $sql = "INSERT INTO user (user_fname, user_lname, user_email, user_password) VALUES (:firstname, :lastname, :email, :password)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function verifyUser($email, $password){
        try{
            $sql = "SELECT * FROM user WHERE user_email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
 
            return true;


        }catch(PDOException $e){
            error_log("Error verifying user: " . $e->getMessage());
            return false;
        }
    }

}

?>