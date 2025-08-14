<?php

class purchases_model extends ceemain{


    public static function store($name, $supplier, $quantity, $price, $date) {
        $key = configurations::systemkey();
        $sql = "INSERT INTO purchases 
                SET 
                name = AES_ENCRYPT('".$name."','".$key."'), 
                supplier = AES_ENCRYPT('".$supplier."','".$key."'),  
                quantity = AES_ENCRYPT('".$quantity."','".$key."'), 
                price = AES_ENCRYPT('".$price."','".$key."'), 
                date = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    
    
    public static function getPurchases() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    p.id,
                    AES_DECRYPT(p.name, '".$key."') AS name,
                    AES_DECRYPT(p.supplier, '".$key."') AS supplier,
                    AES_DECRYPT(p.quantity, '".$key."') AS quantity,
                    AES_DECRYPT(p.price, '".$key."') AS price,
                    AES_DECRYPT(p.date, '".$key."') AS date
                FROM purchases p";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getPurchaseById($id) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    p.id,
                    AES_DECRYPT(p.name, '".$key."') AS name,
                    AES_DECRYPT(p.supplier, '".$key."') AS supplier,
                    AES_DECRYPT(p.quantity, '".$key."') AS quantity,
                    AES_DECRYPT(p.price, '".$key."') AS price,
                    AES_DECRYPT(p.date, '".$key."') AS date
                FROM purchases p
                WHERE p.id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }


    public static function update($id, $name, $supplier, $quantity, $price, $date) {
        $key = configurations::systemkey();
        $sql = "UPDATE purchases 
                SET 
                name = AES_ENCRYPT('".$name."','".$key."'), 
                supplier = AES_ENCRYPT('".$supplier."','".$key."'),  
                quantity = AES_ENCRYPT('".$quantity."','".$key."'), 
                price = AES_ENCRYPT('".$price."','".$key."'), 
                date = AES_ENCRYPT('".$date."','".$key."') 
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            // make sure a row is affected before returning success
            if ($conn->affected_rows > 0) {
                return 1;
            } else {
                return 0; // No rows updated
            }
        } else {
            return $conn->error; 
        }
    }

    static function getTotalpurchases() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    COUNT(*) AS total_purchases
                FROM purchases";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    public static function delete($id) {
        $key = configurations::systemkey();
        $sql = "DELETE FROM purchases WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }








}