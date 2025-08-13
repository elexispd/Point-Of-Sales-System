<?php

class products_model extends ceemain{


    public static function store($name, $brand, $category, $stock, $price) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO products 
                SET 
                name = AES_ENCRYPT('".$name."','".$key."'), 
                brand = AES_ENCRYPT('".$brand."','".$key."'), 
                category = AES_ENCRYPT('".$category."','".$key."'), 
                stock = AES_ENCRYPT('".$stock."','".$key."'), 
                price = AES_ENCRYPT('".$price."','".$key."'), 
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
    
    public static function getProducts() {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    p.id,
                    AES_DECRYPT(p.name, '".$key."') AS name,
                    AES_DECRYPT(p.brand, '".$key."') AS brand,
                    AES_DECRYPT(p.category, '".$key."') AS category,
                    AES_DECRYPT(c.name, '".$key."') AS category_name,
                    AES_DECRYPT(p.stock, '".$key."') AS stock,
                    AES_DECRYPT(p.price, '".$key."') AS price,
                    AES_DECRYPT(p.status, '".$key."') AS status,
                    AES_DECRYPT(p.created_at, '".$key."') AS created_at
                FROM products p
                LEFT JOIN categories c 
                    ON AES_DECRYPT(p.category, '".$key."') = c.id";

        $result = $conn->query($sql);

        if ($result) {
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            return $products;
        } else {
            return [];
        }
    }

    public static function getProductById($id) {
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    p.id,
                    AES_DECRYPT(p.name, '".$key."') AS name,
                    AES_DECRYPT(p.brand, '".$key."') AS brand,
                    AES_DECRYPT(p.category, '".$key."') AS category,
                    AES_DECRYPT(c.name, '".$key."') AS category_name,
                    AES_DECRYPT(p.stock, '".$key."') AS stock,
                    AES_DECRYPT(p.price, '".$key."') AS price,
                    AES_DECRYPT(p.status, '".$key."') AS status,
                    AES_DECRYPT(p.created_at, '".$key."') AS created_at
                FROM products p
                LEFT JOIN categories c 
                    ON AES_DECRYPT(p.category, '".$key."') = c.id
                WHERE p.id = $id";

        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }



    static function updateStatus($id, $status) {
        $key = configurations::systemkey();
        $sql = "UPDATE products 
                SET status =  AES_ENCRYPT('".$status."','".$key."')
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    static function updateProduct($id, $name, $brand, $category, $stock, $price) {
        $key = configurations::systemkey();
        $sql = "UPDATE products 
                SET
                 name = AES_ENCRYPT('".$name."','".$key."'),
                 brand = AES_ENCRYPT('".$brand."','".$key."'),
                 name = AES_ENCRYPT('".$name."','".$key."'),
                 category = AES_ENCRYPT('".$category."','".$key."'),
                 stock = AES_ENCRYPT('".$stock."','".$key."'),
                 price = AES_ENCRYPT('".$price."','".$key."')              
                 WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    static function getTotalProducts() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    COUNT(*) AS total_products
                FROM products";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    static function isProductExist($name, $brand) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name
                FROM products 
                WHERE
                 name = AES_ENCRYPT('".$name."','".$key."')
                 AND 
                 brand = AES_ENCRYPT('".$brand."','".$key."')
                ";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows;
    }
    







}