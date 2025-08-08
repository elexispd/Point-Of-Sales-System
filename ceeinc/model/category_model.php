<?php

class category_model extends ceemain{

    static function store($name, $amount){	
        $key = configurations::systemkey(); 
        $date = date("YmdHis",time());
        $sql = "INSERT INTO categories 
                SET name = AES_ENCRYPT('".$name."','".$key."') , 
                amount = AES_ENCRYPT('".$amount."','".$key."') , 
                status = AES_ENCRYPT('1','".$key."') ,
                created_at = AES_ENCRYPT('".$date."','".$key."') ";   
        $conn = db::createion();     
        $result = $conn->query($sql);         
        if($result === true){             
            return 1;            
        }else{               
            return $conn->error;
        }	
    }
   

    static function getCategories() {
        $key = configurations::systemkey(); 
        $sql = "SELECT id,
                AES_DECRYPT(name,'".$key."') as name, 
                AES_DECRYPT(amount,'".$key."') as amount, 
                AES_DECRYPT(created_at,'".$key."') as created_at, 
                AES_DECRYPT(status,'".$key."') as status
                FROM categories";
        $result1 = Cee_Model::query($sql);
        $result = $result1[0];
        $conn =  $result1[1];
        
        $data = [];
        
        while($rows =  $result->fetch_assoc()) {
            $data[] =  $rows;
        }
        return $data; 
    }
    static function getCategoryById($id) {
        $key = configurations::systemkey(); 
        $sql = "SELECT id,
                AES_DECRYPT(name,'".$key."') as name, 
                AES_DECRYPT(amount,'".$key."') as amount, 
                AES_DECRYPT(created_at,'".$key."') as created_at, 
                AES_DECRYPT(status,'".$key."') as status
                FROM categories WHERE id = $id";
        $result1 = Cee_Model::query($sql);
        $result = $result1[0];
        $conn =  $result1[1];
        return $result->fetch_assoc(); 
    }

    static function getCategoryAmount($category){
        $key = configurations::systemkey(); 
        $sql = "SELECT AES_DECRYPT(amount,'".$key."') as amount FROM categories WHERE id = $category";
        $result1 = Cee_Model::query($sql);
        $result = $result1[0];
        $conn =  $result1[1];
        $data = $result->fetch_assoc();
        return $data['amount'];
    }





}