<?php

class permissions_model extends ceemain{


    public static function store($name) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO permissions 
                SET name = AES_ENCRYPT('".$name."','".$key."'), 
                    status = AES_ENCRYPT('1','".$key."'), 
                    created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    
    
    public static function getPermissions() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name,
                    AES_DECRYPT(status, '".$key."') AS status
                FROM permissions
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result) {
            $permissions = [];
            while ($row = $result->fetch_assoc()) {
                $permissions[] = $row;
            }
            return $permissions; // Return the list of permissions with wallet details
        } else {
            return []; // Return an empty array if the query fails
        }
    }
    

    static function getPermissionById($id) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name
                    FROM permissions 
                    WHERE id = $id
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }


    static function updatePermissionstatus($id, $status) {
        $key = configurations::systemkey();
        $sql = "UPDATE permissions 
                SET status =  AES_ENCRYPT('".$status."','".$key."')
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    static function changeName($id, $name) {
        $key = configurations::systemkey();
        $sql = "UPDATE permissions SET name = AES_ENCRYPT('".$name."','".$key."') WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    static function getTotalPermissions() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    COUNT(*) AS total_permissions
                FROM permissions";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    static function isPermissionExist($name) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name
                FROM permissions 
                WHERE name = AES_ENCRYPT('".$name."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows;
    }
    static function isPermissionExistById($id) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id
                FROM permissions 
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows;
    }







}