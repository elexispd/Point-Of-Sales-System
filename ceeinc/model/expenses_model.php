<?php

class expenses_model extends ceemain{


    public static function store($type, $description, $amount, $date) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO expenses 
                SET 
                type = AES_ENCRYPT('".$type."','".$key."'), 
                description = AES_ENCRYPT('".$description."','".$key."'), 
                amount = AES_ENCRYPT('".$amount."','".$key."'),  
                created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    
    
    public static function searchExpenses($type, $start_date = null, $end_date = null ) {
        $key = configurations::systemkey();
        $conn = db::createion();

        // Convert dates from MM/DD/YYYY to YmdHis (00:00:00 for start, 23:59:59 for end)
        if (!empty($start_date)) {
            $start_date = DateTime::createFromFormat('m/d/Y', $start_date)->format('Ymd') . "000000";
        }
        if (!empty($end_date)) {
            $end_date = DateTime::createFromFormat('m/d/Y', $end_date)->format('Ymd') . "235959";
        }

        $sql = "SELECT 
                    AES_DECRYPT(type, '".$key."') AS type,
                    AES_DECRYPT(description, '".$key."') AS description,
                    AES_DECRYPT(amount, '".$key."') AS amount,
                    AES_DECRYPT(created_at, '".$key."') AS created_at
                FROM expenses
                WHERE type = AES_ENCRYPT('".$type."','".$key."')
                ";

        // Apply filters
        if (!empty($start_date)) {
            $sql .= " AND AES_DECRYPT(created_at, '".$key."') >= '".$conn->real_escape_string($start_date)."'";
        }
        if (!empty($end_date)) {
            $sql .= " AND AES_DECRYPT(created_at, '".$key."') <= '".$conn->real_escape_string($end_date)."'";
        }

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $sales = [];
            while ($row = $result->fetch_assoc()) {
                $sales[] = $row;
            }
            return $sales;
        } else {
            return [];
        }
    }



 



    




}