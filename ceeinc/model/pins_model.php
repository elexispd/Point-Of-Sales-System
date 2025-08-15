<?php

class pins_model extends ceemain{


    public static function store($email, $pin) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO pin 
                SET email = AES_ENCRYPT('".$email."','".$key."'), 
                    pin = AES_ENCRYPT('".$pin."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    

    

    static function getPinByEmail($email) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(pin, '".$key."') AS pin
                    FROM permissions 
                    WHERE emai = AES_ENCRYPT('".$email."','".$key."')
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }


    static function updatePin($id, $pin) {
        $key = configurations::systemkey();
        $sql = "UPDATE pin 
                SET pin =  AES_ENCRYPT('".$pin."','".$key."')
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }




    static function isPinExist($email, $pin) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id
                FROM pin 
                WHERE pin = AES_ENCRYPT('".$pin."','".$key."')
                AND
                email = AES_ENCRYPT('".$email."','".$key."')
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows;
    }
  






}