<?php

class incomes_model extends ceemain{


    public static function store($type, $description, $amount, $date) {
        $key = configurations::systemkey();
        $created_at = date("YmdHis", time());
        $sql = "INSERT INTO incomes 
                SET 
                type = AES_ENCRYPT('".$type."','".$key."'), 
                description = AES_ENCRYPT('".$description."','".$key."'), 
                amount = AES_ENCRYPT('".$amount."','".$key."'),  
                income_date = AES_ENCRYPT('".$date."','".$key."'),  
                created_at = AES_ENCRYPT('".$created_at."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    
    
    public static function searchIncome($type, $start_date = null, $end_date = null ) {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    AES_DECRYPT(type, '".$key."') AS type,
                    AES_DECRYPT(description, '".$key."') AS description,
                    AES_DECRYPT(amount, '".$key."') AS amount,
                    AES_DECRYPT(income_date, '".$key."') AS date,
                    AES_DECRYPT(created_at, '".$key."') AS created_at
                FROM incomes
                WHERE type = AES_ENCRYPT('".$type."','".$key."')
                ";

        if (!empty($start_date)) {
            $sql .= " AND AES_DECRYPT(income_date, '".$key."') >= '".$conn->real_escape_string($start_date)."'";
        }
        if (!empty($end_date)) {
            $sql .= " AND AES_DECRYPT(income_date, '".$key."') <= '".$conn->real_escape_string($end_date)."'";
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