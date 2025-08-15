<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class sales_api extends ceemain
{
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $product_id = Input::post('product_id');   
                $quantity = Input::post('quantity');   
                $cashier_id = Input::post('cashier_id');   
                $price = Input::post('price');   
                $discount = Input::post('discount') ?: 0;
                $tax = Input::post('tax') ?: 0;
                $shipping_cost = Input::post('shipping_cost') ?: 0;   
                $subtotal = Input::post('subtotal');   
                $payment_method = Input::post('payment_method');   
                $subtotal = strtolower(trim($subtotal)); 

                if(!empty($product_id) && !empty($quantity) && !empty($cashier_id) && !empty($price) && !empty($subtotal) && !empty($payment_method)) {
                    if(!is_numeric($product_id) || !is_numeric($quantity)) {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Product ID and Quantity must be numeric"];
                        echo json_encode($response);
                        return;
                    }
                    $result = sales_model::store($product_id, $cashier_id, $quantity, $price, $subtotal, $payment_method, $discount, $tax, $shipping_cost);

                    if($result) {
                        $stock = [
                            "product_id" => $product_id,
                            "quantity" => $quantity,
                            "cashier_id" => $cashier_id,
                            "price" => $price,
                            "subtotal" => $subtotal,
                            "payment_method" => $payment_method
                        ];
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Sales Successful", 'data' => $stock];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to add sales"];
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
   
    function getSales() {
        $response = [1];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = sales_model::getSales();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Sales Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Sales not found", 'data' => []];
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
    
    function getSalesSummary() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = sales_model::getSalesSummary();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Sales Summary Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Sales Summary not found", 'data' => []];
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

    function searchSales() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $start_date = Input::get('start_date');
                $end_date = Input::get('end_date');

                $start_date = str_replace('-', '/', $start_date);
                $end_date = str_replace('-', '/', $end_date);


                $product_id = Input::get('product_id');
                $brand = Input::get('brand');
                $category = Input::get('category');

                $result = sales_model::searchSales($start_date, $end_date, $product_id, $brand, $category);
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Sales Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Sales not found", 'data' => []];
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