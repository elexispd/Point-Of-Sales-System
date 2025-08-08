<?php

class users_model extends ceemain{


    public static function store($name, $email, $phone, $role, $password) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO users 
                SET name = AES_ENCRYPT('".$name."','".$key."'), 
                    password = AES_ENCRYPT('".$password."','".$key."'), 
                    email = AES_ENCRYPT('".$email."','".$key."'), 
                    phone = AES_ENCRYPT('".$phone."','".$key."'), 
                    role = AES_ENCRYPT('".$role."','".$key."'),   
                    status = AES_ENCRYPT('1','".$key."'), 
                    created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            $user_id = $conn->insert_id; 
            return $user_id; // Return the user ID
        } else {
            return $conn->error; 
        }
    }   
    public static function storeCustomer($name, $email, $phone, $password, $address) {
        $role = "customer";
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO users 
                SET name = AES_ENCRYPT('".$name."','".$key."'), 
                    password = AES_ENCRYPT('".$password."','".$key."'), 
                    email = AES_ENCRYPT('".$email."','".$key."'), 
                    phone = AES_ENCRYPT('".$phone."','".$key."'), 
                    role = AES_ENCRYPT('".$role."','".$key."'),   
                    address = AES_ENCRYPT('".$address."','".$key."'),   
                    status = AES_ENCRYPT('1','".$key."'), 
                    created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            $user_id = $conn->insert_id; 
            return $user_id; // Return the user ID
        } else {
            return $conn->error; 
        }
    }   
    
    public static function getStaff() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(phone, '".$key."') AS phone,
                    AES_DECRYPT(role, '".$key."') AS role,
                    AES_DECRYPT(status, '".$key."') AS status
                FROM users
                WHERE role != AES_ENCRYPT('customer','".$key."')
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users; // Return the list of users with wallet details
        } else {
            return []; // Return an empty array if the query fails
        }
    }
    public static function getCustomers() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(phone, '".$key."') AS phone,
                    AES_DECRYPT(role, '".$key."') AS role,
                    AES_DECRYPT(status, '".$key."') AS status
                FROM users
                WHERE role = AES_ENCRYPT('customer','".$key."')
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users; // Return the list of users with wallet details
        } else {
            return []; // Return an empty array if the query fails
        }
    }

   
    static function getUserByEmail($email) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(phone, '".$key."') AS phone,
                    AES_DECRYPT(role, '".$key."') AS role,
                    AES_DECRYPT(status, '".$key."') AS status
                    FROM users 
                    WHERE email = AES_ENCRYPT('".$email."','".$key."')
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    static function getUserByPassword($email) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(password, '".$key."') AS password
                    FROM users 
                    WHERE email = AES_ENCRYPT('".$email."','".$key."')
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    static function getUserById($id) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(phone, '".$key."') AS phone,
                    AES_DECRYPT(role, '".$key."') AS role,
                    AES_DECRYPT(status, '".$key."') AS status
                    FROM users 
                    WHERE id = $id
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

     static function getUsersByRole($role) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(phone, '".$key."') AS phone,
                    AES_DECRYPT(role, '".$key."') AS role,
                    AES_DECRYPT(status, '".$key."') AS status
                    FROM users 
                    WHERE role = AES_ENCRYPT('".$role."','".$key."')
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    static function auth($email,$password){
    	$key = configurations::systemkey(); 
    	$sql = "SELECT id FROM users 
                WHERE email = AES_ENCRYPT('".$email."','".$key."') &&
                password = AES_ENCRYPT('".$password."','".$key."')";
    	$result1 = Cee_Model::query($sql);
    	$result = $result1[0];
    	$conn =  $result1[1];  	
    	if($result->num_rows > 0 ){
    		return $result->fetch_assoc()["id"];
    		}else{
    		return 0;	
    	}
    }

    static function updateUserStatus($id, $status) {
        $key = configurations::systemkey();
        $sql = "UPDATE users 
                SET status =  AES_ENCRYPT('".$status."','".$key."')
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }
  
   

    static function isEmailExist($email) {
        $key = configurations::systemkey();
        $sql = "SELECT * FROM users WHERE email = AES_ENCRYPT('".$email."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }

    static function changePassword($email, $password) {
        $key = configurations::systemkey();
        $sql = "UPDATE users SET password = AES_ENCRYPT('".$password."','".$key."') WHERE email = AES_ENCRYPT('".$email."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    static function getTotalUsers() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    COUNT(*) AS total_users
                FROM users";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }







}