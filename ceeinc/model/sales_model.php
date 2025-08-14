<?php

class sales_model extends ceemain{


    public static function store($product_id, $cashier_id, $quantity, $price, $subtotal, $payment_method) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO sales 
                SET 
                product_id = AES_ENCRYPT('".$product_id."','".$key."'), 
                cashier_id = AES_ENCRYPT('".$cashier_id."','".$key."'), 
                quantity = AES_ENCRYPT('".$quantity."','".$key."'), 
                price = AES_ENCRYPT('".$price."','".$key."'), 
                subtotal = AES_ENCRYPT('".$subtotal."','".$key."'), 
                payment_method = AES_ENCRYPT('".$payment_method."','".$key."'), 
                created_at = AES_ENCRYPT('".$date."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }    
    
   public static function getSales() {
        // join with product and user table to get  product name and cashier name 
        $key = configurations::systemkey();
        $sql = "SELECT 
                AES_DECRYPT(s.product_id, '".$key."') AS product_id, 
                AES_DECRYPT(s.cashier_id, '".$key."') AS cashier_id, 
                AES_DECRYPT(s.quantity, '".$key."') AS quantity, 
                AES_DECRYPT(s.price, '".$key."') AS price, 
                AES_DECRYPT(s.subtotal, '".$key."') AS subtotal, 
                AES_DECRYPT(s.payment_method, '".$key."') AS payment_method, 
                AES_DECRYPT(s.created_at, '".$key."') AS created_at,
                AES_DECRYPT(p.name, '".$key."') AS product_name,
                AES_DECRYPT(u.name, '".$key."') AS cashier_name
                FROM sales s
                JOIN products p ON p.id = AES_DECRYPT(s.product_id, '".$key."')
                JOIN users u ON u.id = AES_DECRYPT(s.cashier_id, '".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sales = [];
            while ($row = $result->fetch_assoc()) {
                $sales[] = $row;
            }
            return $sales;
        } else {
            return false; // No sales found
        }
   }

    public static function searchSales($start_date = null, $end_date = null, $product_id = null, $brand = null, $category = null) {
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
                AES_DECRYPT(s.product_id, '".$key."') AS product_id, 
                AES_DECRYPT(s.cashier_id, '".$key."') AS cashier_id, 
                AES_DECRYPT(s.quantity, '".$key."') AS quantity, 
                AES_DECRYPT(s.price, '".$key."') AS price, 
                AES_DECRYPT(s.subtotal, '".$key."') AS subtotal, 
                AES_DECRYPT(s.payment_method, '".$key."') AS payment_method, 
                AES_DECRYPT(s.created_at, '".$key."') AS created_at,
                AES_DECRYPT(p.name, '".$key."') AS product_name,
                AES_DECRYPT(p.brand, '".$key."') AS brand,
                AES_DECRYPT(p.category, '".$key."') AS category,
                AES_DECRYPT(u.name, '".$key."') AS cashier_name
            FROM sales s
            JOIN products p 
                ON p.id = CAST(AES_DECRYPT(s.product_id, '".$key."') AS UNSIGNED)
            JOIN users u 
                ON u.id = CAST(AES_DECRYPT(s.cashier_id, '".$key."') AS UNSIGNED)
            WHERE 1=1";

    // Apply filters
    if (!empty($start_date)) {
        $sql .= " AND AES_DECRYPT(s.created_at, '".$key."') >= '".$conn->real_escape_string($start_date)."'";
    }
    if (!empty($end_date)) {
        $sql .= " AND AES_DECRYPT(s.created_at, '".$key."') <= '".$conn->real_escape_string($end_date)."'";
    }
    if (!empty($product_id)) {
        $sql .= " AND AES_DECRYPT(s.product_id, '".$key."') = '".$conn->real_escape_string($product_id)."'";
    }
    if (!empty($brand)) {
        $sql .= " AND AES_DECRYPT(p.brand, '".$key."') LIKE '%".$conn->real_escape_string($brand)."%'";
    }
    if (!empty($category)) {
        $sql .= " AND AES_DECRYPT(p.category, '".$key."') LIKE '%".$conn->real_escape_string($category)."%'";
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



    public static function getSalesSummary() {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    COUNT(*) AS total_sales, 
                    SUM(CAST(AES_DECRYPT(s.subtotal, '".$key."') AS DECIMAL(10,2))) AS total_revenue, 
                    SUM(CAST(AES_DECRYPT(s.quantity, '".$key."') AS UNSIGNED)) AS total_products_sold
                FROM sales s";

        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            return $row;
        } else {
            return [
                'total_sales' => 0,
                'total_revenue' => 0.00,
                'total_products_sold' => 0
            ];
        }
    }

    



    




}