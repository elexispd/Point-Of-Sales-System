<?php

class stocks_model extends ceemain{


    public static function store($product_id, $quantity, $supplier, $stock_type) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO stocks 
                SET 
                product_id = AES_ENCRYPT('".$product_id."','".$key."'), 
                quantity = AES_ENCRYPT('".$quantity."','".$key."'), 
                supplier = AES_ENCRYPT('".$supplier."','".$key."'), 
                stock_type = AES_ENCRYPT('".$stock_type."','".$key."'), 
                created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    
    
    public static function getStocks() {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    s.id,
                    AES_DECRYPT(s.product_id, '".$key."') AS product_id,
                    AES_DECRYPT(p.name, '".$key."') AS product_name,
                    AES_DECRYPT(s.quantity, '".$key."') AS quantity,
                    AES_DECRYPT(s.supplier, '".$key."') AS supplier,
                    AES_DECRYPT(s.stock_type, '".$key."') AS stock_type,
                    AES_DECRYPT(s.created_at, '".$key."') AS created_at
                FROM stocks s
                INNER JOIN products p 
                    ON p.id = CAST(AES_DECRYPT(s.product_id, '".$key."') AS UNSIGNED)";
        
        $result = $conn->query($sql);

        if ($result) {
            $stocks = [];
            while ($row = $result->fetch_assoc()) {
                $stocks[] = $row;
            }
            return $stocks;
        } else {
            return [];
        }
    }
    public static function getStockByType($type) {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    s.id,
                    AES_DECRYPT(s.product_id, '".$key."') AS product_id,
                    AES_DECRYPT(p.name, '".$key."') AS product_name,
                    AES_DECRYPT(s.quantity, '".$key."') AS quantity,
                    AES_DECRYPT(s.supplier, '".$key."') AS supplier,
                    AES_DECRYPT(s.stock_type, '".$key."') AS stock_type,
                    AES_DECRYPT(s.created_at, '".$key."') AS created_at
                FROM stocks s
                INNER JOIN products p 
                    ON p.id = CAST(AES_DECRYPT(s.product_id, '".$key."') AS UNSIGNED)                    
                WHERE AES_DECRYPT(s.stock_type, '".$key."') = '".$type."'";
        
        $result = $conn->query($sql);

        if ($result) {
            $stocks = [];
            while ($row = $result->fetch_assoc()) {
                $stocks[] = $row;
            }
            return $stocks;
        } else {
            return [];
        }
    }

    

    public static function getStockById($id) {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    s.id,
                    AES_DECRYPT(s.product_id, '".$key."') AS product_id,
                    AES_DECRYPT(p.name, '".$key."') AS product_name,
                    AES_DECRYPT(s.quantity, '".$key."') AS quantity,
                    AES_DECRYPT(s.supplier, '".$key."') AS supplier,
                    AES_DECRYPT(s.stock_type, '".$key."') AS stock_type,
                    AES_DECRYPT(s.created_at, '".$key."') AS created_at
                FROM stocks s
                INNER JOIN products p 
                    ON p.id = CAST(AES_DECRYPT(s.product_id, '".$key."') AS UNSIGNED)
                WHERE s.id = $id";
        
        $result = $conn->query($sql);

        if ($result) {
            return $result->fetch_assoc();
        } else {
            return [];
        }
    }
    public static function getStockByProduct($product_id) {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    s.id,
                    AES_DECRYPT(s.product_id, '".$key."') AS product_id,
                    AES_DECRYPT(p.name, '".$key."') AS product_name,
                    AES_DECRYPT(s.quantity, '".$key."') AS quantity,
                    AES_DECRYPT(s.supplier, '".$key."') AS supplier,
                    AES_DECRYPT(s.stock_type, '".$key."') AS stock_type,
                    AES_DECRYPT(s.created_at, '".$key."') AS created_at
                FROM stocks s
                INNER JOIN products p 
                    ON p.id = CAST(AES_DECRYPT(s.product_id, '".$key."') AS UNSIGNED)
                WHERE product_id = AES_ENCRYPT('".$product_id."','".$key."')";

        $result = $conn->query($sql);

        $stocks = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $stocks[] = $row;
            }
        }
        return $stocks;
    }




    static function updateStock($id, $quantity, $supplier) {
        $key = configurations::systemkey();
        $sql = "UPDATE stocks 
                SET
                 quantity = AES_ENCRYPT('".$quantity."','".$key."'),
                 supplier = AES_ENCRYPT('".$supplier."','".$key."'),            
                 WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

  







}