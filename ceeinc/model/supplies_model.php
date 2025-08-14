<?php

class supplies_model extends ceemain{


    public static function store($name, $contact, $email, $address) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO supplies 
                SET 
                name = AES_ENCRYPT('".$name."','".$key."'), 
                contact = AES_ENCRYPT('".$contact."','".$key."'), 
                email = AES_ENCRYPT('".$email."','".$key."'), 
                address = AES_ENCRYPT('".$address."','".$key."'), 
                status = AES_ENCRYPT('active','".$key."'), 
                created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    
    
    public static function getSuppliers() {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(contact, '".$key."') AS contact,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(address, '".$key."') AS address,
                    AES_DECRYPT(status, '".$key."') AS status,
                    AES_DECRYPT(created_at, '".$key."') AS created_at
                FROM supplies";
        $result = $conn->query($sql);

        if ($result) {
            $suppliers = [];
            while ($row = $result->fetch_assoc()) {
                $suppliers[] = $row;
            }
            return $suppliers;
        } else {
            return [];
        }
    }

    public static function getSupplierById($id) {
        $key = configurations::systemkey();
        $conn = db::createion();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(contact, '".$key."') AS contact,
                    AES_DECRYPT(email, '".$key."') AS email,
                    AES_DECRYPT(address, '".$key."') AS address,
                    AES_DECRYPT(status, '".$key."') AS status,
                    AES_DECRYPT(created_at, '".$key."') AS created_at
                FROM supplies WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    public static function edit($id, $name, $contact, $email, $address) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "UPDATE supplies 
                SET 
                name = AES_ENCRYPT('".$name."','".$key."'), 
                contact = AES_ENCRYPT('".$contact."','".$key."'), 
                email = AES_ENCRYPT('".$email."','".$key."'), 
                address = AES_ENCRYPT('".$address."','".$key."')
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    public static function delete($id) {
        $key = configurations::systemkey();
        $sql = "DELETE FROM supplies WHERE id = ?";
        $conn = db::createion();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        return $result;
    }


    




}