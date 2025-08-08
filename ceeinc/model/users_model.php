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
    
    public static function getUsers() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(phone, '".$key."') AS phone,
                    AES_DECRYPT(role, '".$key."') AS role,
                    AES_DECRYPT(status, '".$key."') AS status
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

    static function updateBalance($user_id, $new_balance) {
        $key = configurations::systemkey();
        $sql = "UPDATE wallet 
                SET balance =  AES_ENCRYPT('".$new_balance."','".$key."')
                WHERE user_id = AES_ENCRYPT('".$user_id."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }
    static function updateStatus($id, $status) {
        $key = configurations::systemkey();
        $sql = "UPDATE users 
                SET status =  AES_ENCRYPT('".$status."','".$key."')
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }
    static function updateBankInfo($user_id, $bank, $account_no) {
        $key = configurations::systemkey();
        $sql = "UPDATE users_info 
                SET bank =  AES_ENCRYPT('".$bank."','".$key."'),
                account_number =  AES_ENCRYPT('".$account_no."','".$key."')
                WHERE user_id = AES_ENCRYPT('".$user_id."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    static function username()
	{
		if (Session::ceedata("cip_username") == "username") {
			return Session::ceedata("cip_username");
		} else {
			return Session::ceedata("cip_username");
		}

	}
    

    static function isUsernameExist($username) {
        $key = configurations::systemkey();
        $sql = "SELECT * FROM users WHERE username = AES_ENCRYPT('".$username."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }
    static function isPhoneExist($phone) {
        $key = configurations::systemkey();
        $sql = "SELECT * FROM users WHERE phone = AES_ENCRYPT('".$phone."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }
    static function isBvnExist($bvn) {
        $key = configurations::systemkey();
        $sql = "SELECT * FROM users_info WHERE bvn = AES_ENCRYPT('".$bvn."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows > 0;
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