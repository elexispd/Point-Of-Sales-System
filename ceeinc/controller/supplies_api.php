<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class supplies_api extends ceemain
{
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $name = Input::post('name');   
                $email = Input::post('email');   
                $contact = Input::post('contact');   
                $address = Input::post('address');   

                if(!empty($name) && !empty($email) && !empty($contact) && !empty($address)) {                   
                    $result = supplies_model::store($name, $contact, $email, $address);
                    if($result) {
                        $supplies = [
                            "name" => $name,
                            "contact" => $contact,
                            "email" => $email,
                            "address" => $address
                        ];
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Supplier Added Successful", 'data' => $supplies];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to add supplier"];
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
   
    function getSuppliers() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = supplies_model::getSuppliers();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Suppliers Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Suppliers not found", 'data' => []];
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

    function edit() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $name = Input::post('name');   
                $email = Input::post('email');   
                $contact = Input::post('contact');   
                $address = Input::post('address');   
                $supplier_id = Input::post('supplier_id');   

                if(!empty($name) && !empty($email) && !empty($contact) && !empty($address)) {                   
                    $result = supplies_model::edit($supplier_id, $name, $contact, $email, $address);
                    if($result) {
                        $supplies = [
                            "name" => $name,
                            "contact" => $contact,
                            "email" => $email,
                            "address" => $address
                        ];
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Supplier Updated Successful", 'data' => $supplies];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to edit supplier"];
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