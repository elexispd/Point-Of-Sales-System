<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class expenses_api extends ceemain
{
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $type = Input::post('type');   
                $description = Input::post('description');      
                $amount = Input::post('amount');      
                $date = Input::post('date');   

                if(!empty($type) && !empty($description) && !empty($amount) ) {
                    $result = expenses_model::store($type, $description, $amount, $date);

                    if($result) {
                        $expenses = [
                            "type" => $type,
                            "description" => $description,
                            "amount" => $amount,
                            "date" => $date
                        ];
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Expense Successful", 'data' => $expenses];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to add expense"];
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
   
    function searchExpenses() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $start_date = Input::get('start_date');
                $end_date = Input::get('end_date');

                $start_date = str_replace('-', '/', $start_date);
                $end_date = str_replace('-', '/', $end_date);


                $type = Input::get('type');

                $result = expenses_model::searchExpenses($type, $start_date, $end_date);
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Expenses Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Expenses not found", 'data' => []];
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