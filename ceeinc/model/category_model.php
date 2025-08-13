<?php

class category_model extends ceemain{


    public static function store($name) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO categories 
                SET 
                name = AES_ENCRYPT('".$name."','".$key."'), 
                created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    
    
    public static function getCategories() {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(created_at, '".$key."') AS created_at
                FROM categories";
        $result = $conn->query($sql);

        if ($result) {
            $categories = [];
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
            return $categories;
        } else {
            return [];
        }
    }

    




}