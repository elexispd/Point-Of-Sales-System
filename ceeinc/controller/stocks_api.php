<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class stocks_api extends ceemain
{
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $product_id = Input::post('product_id');   
                $quantity = Input::post('quantity');   
                $supplier = Input::post('supplier');   
                $stock_type = Input::post('stock_type');   
                $supplier = strtolower(trim($supplier)); 

                if(!empty($product_id) && !empty($quantity) && !empty($supplier) && !empty($stock_type)) {
                    if(!is_numeric($product_id) || !is_numeric($quantity)) {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Product ID and Quantity must be numeric"];
                        echo json_encode($response);
                        return;
                    }
                    if(!in_array($stock_type, ['in', 'out'])) {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Invalid stock type"];
                        echo json_encode($response);
                        return;
                    }
                    $result = stocks_model::store($product_id, $quantity, $supplier, $stock_type);

                    if($result) {
                        $stock = [
                            "product_id" => $product_id,
                            "quantity" => $quantity,
                            "supplier" => $supplier,
                            "stock_type" => $stock_type
                        ];
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Stock Action Successful", 'data' => $stock];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to add stock"];
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
   
    function getAllStocks() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = stocks_model::getStocks();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Stocks Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Stock not found", 'data' => []];
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
    function getProductStocks() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $product_id = Input::get('product_id');
                $result = stocks_model::getStockByProduct($product_id);
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Stocks Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Stocks not found", 'data' => []];
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

    function getStockById() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $id = Input::get('stock_id');
                $result = stocks_model::getStockById($id);
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Stock Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Stocks not found", 'data' => []];
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

    function getStockByType()
    {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $type = Input::get('stock_type');
                if(!empty($type)) {
                    $result = stocks_model::getStockByType($type);
                    if($result) {
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Stocks Found successfully", 'data' => $result];
                    } else {
                        http_response_code(404); // Not Found
                        $response = ["status" => 0, "message" => "No Stock found", 'data' => []];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Stock type is required"];
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
                    
                    if($result) {
                        if($status ==1) {
                            $statusMessage = "activated";
                        } elseif($status == 0) {
                            $statusMessage = "deactivated";
                        } else {
                            http_response_code(400); // Bad Request
                            $response = ["status" => 0, "message" => "Invalid status value"];
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

    function searchStock() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            if ($auth) {
                $start_date = Input::get('start_date');
                $end_date = Input::get('end_date');
                $product_id = Input::get('product_id');
                $supplier = Input::get('supplier');
                $stock_type = Input::get('stock_type');
                $brand = Input::get('brand');
                $category = Input::get('category');

                $start_date = str_replace('-', '/', $start_date);
                $end_date = str_replace('-', '/', $end_date);

                $result = stocks_model::searchStocks($start_date, $end_date, $product_id, $supplier, $stock_type, $brand, $category);
                
                if($result) {
                    http_response_code(response_code: 200); // OK
                    $response = ["status" => 1, "message" => "Stocks Found successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "No Stock found", 'data' => []];
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