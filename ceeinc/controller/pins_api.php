<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class pins_api extends ceemain
{
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $pin = Input::post('pin');
                
                $email = $auth;

                if(!empty($pin) ) {
                    $is_exit = pins_model::isPinExist($auth, $pin);
                    if($is_exit > 0) {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Pin already exists. Please Update in instead"];
                        echo json_encode($response);
                        return;
                    }
                    $result = pins_model::store($email, $pin);
                    $action = "Create Pin";
                    $user_id = users_model::getUserByEmail($auth)['id'];        
                    if($result) {
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Pin created successfully", 'data' => $pin];
                        $desc= 'Added pin: ' . $pin;                    
                        logs_model::activity_log($user_id, $action, $desc);
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to create Product"];
                        $desc= 'Tried and failed to create pin: ' . $pin;                    
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
   
    function changePin() {
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $id = Input::post('id');
                $pin = Input::post('pin');

                if(! (empty($pin))) {
                    $result = pins_model::updatePin($id, $pin);
                    $action = "Change Pin";
                    $user_id = users_model::getUserByEmail($auth)['id'];  
                    if($result) {
                        
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Pin changed successfully", 'data' => $pin];
                        $desc= 'Changed Pin to: ' . $pin;
                        $action = "Change Pin";
                        logs_model::activity_log($user_id, $action, $desc);

                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to update Pin"];
                        $desc = 'Failed To create pin: ';
                        $action = "Change Pin";
                        logs_model::activity_log($user_id, $action, $desc);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Pin and ID are required"];
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