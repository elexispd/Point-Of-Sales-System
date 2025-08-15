<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class logs_api extends ceemain
{

   
    function getLogs() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = logs_model::getAllLogs();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Activity Logs Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Logs not found", 'data' => []];
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