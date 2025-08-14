<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class purchases_api extends ceemain
{
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $name = Input::post('name');   
                $quantity = Input::post('quantity');   
                $name = strtolower(trim($name)); 
                $supplier = Input::post('supplier_id');
                $date = Input::post('date');
                $price = Input::post('price');
                if(!empty($name) && !empty($date) && !empty($supplier) && !empty($quantity) && !empty($price)) {
                    $result = purchases_model::store($name, $supplier, $quantity, $price, $date);

                    if($result) {
                        $purchase = [
                            "name" => $name,
                            "supplier" => $supplier,
                            "quantity" => $quantity,
                            "price" => $price,
                            "date" => $date
                        ];
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Purchase created successfully", 'data' => $purchase];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to create Purchase"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "All fields are required"];
                }
            } else {
                http_response_code(401); // Unauthorized
                $response = ["status" => 0, "message" => "Unauthorized"];
            }
        } else {
            http_response_code(405); // Method Not Allowed
            $response = ["status" => 0, "message" => "Method not allowed"];
        }
        echo json_encode($response);
    }
   
    function getPurchases() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            if ($auth) {
                $result = purchases_model::getPurchases();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Purchases found successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "No Purchases found"];
                }
            } else {
                http_response_code(401); // Unauthorized
                $response = ["status" => 0, "message" => "Unauthorized"];
            }
        } else {
            http_response_code(405); // Method Not Allowed
            $response = ["status" => 0, "message" => "Method not allowed"];
        }
        echo json_encode($response);
    }

    function getPurchaseById() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            if ($auth) {
                $id = Input::get('purchase_id');
                $result = purchases_model::getPurchaseById($id);
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Purchase found successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Purchase not found"];
                }
            } else {
                http_response_code(401); // Unauthorized
                $response = ["status" => 0, "message" => "Unauthorized"];
            }
        } else {
            http_response_code(405); // Method Not Allowed
            $response = ["status" => 0, "message" => "Method not allowed"];
        }
        echo json_encode($response);
    }
    
    function update() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $id = Input::post('purchase_id');   
                $name = Input::post('name');   
                $supplier = Input::post('supplier');   
                $quantity = Input::post('quantity');   
                $price = Input::post('price');   
                $date = Input::post('date');   

                if(!empty($id) && !empty($name) && !empty($supplier) && !empty($quantity) && !empty($price) && !empty($date)) {  
                    $is_supplier = supplies_model::getSupplierById($supplier);
                    if(!$is_supplier) {
                        http_response_code(404); // Not Found
                        $response = ["status" => 0, "message" => "Supplier not found"];
                        echo json_encode($response);
                        return;
                    }
                    $result = purchases_model::update($id, $name, $supplier, $quantity, $price, $date);
                    if($result) {
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Purchase updated successfully"];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to update Purchase"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "All fields are required"];
                }
            } else {
                http_response_code(401); // Unauthorized
                $response = ["status" => 0, "message" => "Unauthorized"];
            }
        } else {
            http_response_code(405); // Method Not Allowed
            $response = ["status" => 0, "message" => "Method not allowed"];
        }
        echo json_encode($response);
    }

    

 
    

}