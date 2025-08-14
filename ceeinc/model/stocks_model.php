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

    public static function searchStocks($start_date = null, $end_date = null, $product_id = null, $supplier = null, $stock_type = null, $brand = null, $category = null) {
        $key = configurations::systemkey();
        $conn = db::createion();

        // Convert dates from MM/DD/YYYY to YmdHis
        if (!empty($start_date)) {
            $start_date = DateTime::createFromFormat('m/d/Y', $start_date)->format('Ymd') . "000000";
        }
        if (!empty($end_date)) {
            $end_date = DateTime::createFromFormat('m/d/Y', $end_date)->format('Ymd') . "235959";
        }

        $sql = "SELECT 
                    s.id,
                    AES_DECRYPT(s.product_id, '".$key."') AS product_id,
                    AES_DECRYPT(p.name, '".$key."') AS product_name,
                    AES_DECRYPT(p.brand, '".$key."') AS brand,
                    AES_DECRYPT(p.category, '".$key."') AS category,
                    AES_DECRYPT(s.quantity, '".$key."') AS quantity,
                    AES_DECRYPT(s.supplier, '".$key."') AS supplier,
                    AES_DECRYPT(s.stock_type, '".$key."') AS stock_type,
                    AES_DECRYPT(s.created_at, '".$key."') AS created_at
                FROM stocks s
                INNER JOIN products p 
                    ON p.id = CAST(AES_DECRYPT(s.product_id, '".$key."') AS UNSIGNED)
                WHERE 1=1";

        // Apply filters dynamically
        if (!empty($start_date)) {
            $sql .= " AND AES_DECRYPT(s.created_at, '".$key."') >= '".$conn->real_escape_string($start_date)."'";
        }
        if (!empty($end_date)) {
            $sql .= " AND AES_DECRYPT(s.created_at, '".$key."') <= '".$conn->real_escape_string($end_date)."'";
        }
        if (!empty($product_id)) {
            $sql .= " AND AES_DECRYPT(s.product_id, '".$key."') = '".$conn->real_escape_string($product_id)."'";
        }
        if (!empty($supplier)) {
            $sql .= " AND AES_DECRYPT(s.supplier, '".$key."') LIKE '%".$conn->real_escape_string($supplier)."%'";
        }
        if (!empty($stock_type)) {
            $sql .= " AND AES_DECRYPT(s.stock_type, '".$key."') LIKE '%".$conn->real_escape_string($stock_type)."%'";
        }
        if (!empty($brand)) {
            $sql .= " AND AES_DECRYPT(p.brand, '".$key."') LIKE '%".$conn->real_escape_string($brand)."%'";
        }
        if (!empty($category)) {
            $sql .= " AND AES_DECRYPT(p.category, '".$key."') LIKE '%".$conn->real_escape_string($category)."%'";
        }

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $stocks = [];
            while ($row = $result->fetch_assoc()) {
                $stocks[] = $row;
            }
            return $stocks;
        } else {
            return [];
        }
    }


  







}