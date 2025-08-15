<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class products_api extends ceemain
{
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $name = Input::post('name');   
                $brand = Input::post('brand');   
                $name = strtolower(trim($name)); 
                $brand = strtolower(trim($brand)); 
                $category = Input::post('category');
                $stock = Input::post('stock');
                $price = Input::post('price');
                if(!empty($name) && !empty($brand) && !empty($category) && !empty($stock) && !empty($price)) {
                    $is_exit = products_model::isProductExist($name, $brand);
                    if($is_exit > 0) {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Product already exists. Please Stock in instead"];
                        echo json_encode($response);
                        return;
                    }
                    $result = products_model::store($name, $brand, $category, $stock, $price);
                    $action = "Create Product";
                    $user_id = users_model::getUserByEmail($auth)['id'];        
                    if($result) {
                        $product = [
                            "name" => $name,
                            "brand" => $brand,
                            "category" => $category,
                            "stock" => $stock,
                            "price" => $price
                        ];
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Product created successfully", 'data' => $product];
                        $desc= 'Added product of name: ' . $name;                    
                        logs_model::activity_log($user_id, $action, $desc);
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to create Product"];
                        $desc= 'Tried and failed to add product of name: ' . $name;                    
                        logs_model::activity_log($user_id, $action, $desc);
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
   
    function getAllProducts() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = products_model::getProducts();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Products Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Products not found", 'data' => []];
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

    function getProductById()
    {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $id = Input::get('product_id');
                if(!empty($id)) {
                    $result = products_model::getProductById($id);
                    if($result) {
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Product Found successfully", 'data' => $result];
                    } else {
                        http_response_code(404); // Not Found
                        $response = ["status" => 0, "message" => "No Product found"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Product ID is required"];
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

    function updateStatus() {
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $id = Input::post('product_id');
                $status = Input::post('status');

                if(! (empty($id) && empty($status))) {
                    $result = products_model::updateStatus($id, $status);
                    $action = "Activate Product";
                    $user_id = users_model::getUserByEmail($auth)['id'];  
                    if($result) {
                        if($status ==1) {
                            $statusMessage = "activated";
                            $desc= 'Activated product of ID: ' . $id;                    
                            logs_model::activity_log($user_id, $action, $desc);
                        } elseif($status == 0) {
                            $statusMessage = "deactivated";
                            $desc= 'Deactivated product of ID: ' . $id;                    
                            logs_model::activity_log($user_id, $action, $desc);
                        } else {
                            http_response_code(400); // Bad Request
                            $response = ["status" => 0, "message" => "Invalid status value"];
                            $desc= 'Tried and Failed to activate product of ID: ' . $id;                    
                            logs_model::activity_log($user_id, $action, $desc);
                            echo json_encode($response);
                            return;
                        }
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Product status $statusMessage successfully"];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to update Product status"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Product ID and status are required"];
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

    function updateProduct() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            if ($auth) {
                $email = $auth;
                $name = Input::post('name');
                $id = Input::post('product_id');
                $brand = Input::post('brand');
                $category = Input::post('category');
                $stock = Input::post('stock');
                $price = Input::post('price');

                $result = products_model::updateProduct($id, $name, $brand, $category, $stock, $price);
                $action = "Change Product";
                $user_id = users_model::getUserByEmail($auth)['id'];  
                if ($result) {
                    // Regenerate the JWT token after password change
                    $product = products_model::getProductById($id);
                    http_response_code(200); // OK
                    $response = [
                        "status" => 1,
                        "message" => "Product updated successfully",
                        "data" => $product
                    ];
                    $desc= 'Changed Product name to: ' . $name;
                    $action = "Change Product Name";
                    logs_model::activity_log($user_id, $action, $desc);
                    
                    
                } else {
                    http_response_code(400); // Bad Request
                    $response = [
                        "status" => 0,
                        "message" => "Failed to update Product"
                    ];
                }
              
            } else {
                http_response_code(401); // Unauthorized
                $response = [
                    "status" => 0,
                    "message" => "Unauthorized"
                ];
            }
        } else {
            http_response_code(405); // Method Not Allowed
            $response = [
                "status" => 0,
                "message" => "Method not allowed"
            ];
        }
    
        // Return the response as JSON
        echo json_encode($response);
    }

    function getTotalProducts()
    {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = products_model::getTotalProducts();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Total Products Found successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "No Permissions found"];
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