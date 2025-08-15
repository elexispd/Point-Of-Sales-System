<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class incomes_api extends ceemain
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
                    $result = incomes_model::store($type, $description, $amount, $date);

                    $user_id = users_model::getUserByEmail($auth)['id'];
                    $action = 'Create Income';
                    $desc= 'Added income of type: ' . $type . ', amount: ' . $amount . ', date: ' . $date;
                    logs_model::activity_log($user_id, $action, $desc);

                    if($result) {
                        $income = [
                            "type" => $type,
                            "description" => $description,
                            "amount" => $amount,
                            "date" => $date
                        ];
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Income Successful", 'data' => $income];
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
   
    function searchIncome() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $start_date = Input::get('start_date');
                $end_date = Input::get('end_date');


                $type = Input::get('type');

                $result = incomes_model::searchIncome($type, $start_date, $end_date);
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Incomes Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Incomes not found", 'data' => []];
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