<?php

class logs_model extends ceemain{

    //activity_log($user_id, "Stock In", "Added 20 bags of rice", "stocks", $stock_id);

    public static function activity_log($user_id, $action, $description) {
        $key = configurations::systemkey();
        // Get IP Address
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        // Get User Agent
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
        $date = date("YmdHis", time());
        $sql = "INSERT INTO activity_logs 
                SET 
                user_id = AES_ENCRYPT('".$user_id."','".$key."'), 
                action = AES_ENCRYPT('".$action."','".$key."'), 
                description = AES_ENCRYPT('".$description."','".$key."'), 
                ip_address = AES_ENCRYPT('".$ip_address."','".$key."'), 
                user_agent = AES_ENCRYPT('".$user_agent."','".$key."'), 
                created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }

    public static function getAllLogs() {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    AES_DECRYPT(user_id, '".$key."') AS user_id,
                    AES_DECRYPT(action, '".$key."') AS action,
                    AES_DECRYPT(description, '".$key."') AS description,
                    AES_DECRYPT(ip_address, '".$key."') AS ip_address,
                    AES_DECRYPT(user_agent, '".$key."') AS user_agent,
                    AES_DECRYPT(created_at, '".$key."') AS created_at
                FROM activity_logs
                ORDER BY created_at DESC";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $logs = [];
            while ($row = $result->fetch_assoc()) {
                $logs[] = $row;
            }
            return $logs;
        } else {
            return [];
        }
    }
    

  



}