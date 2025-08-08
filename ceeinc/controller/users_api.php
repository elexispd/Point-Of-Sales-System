<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class users_api extends ceemain
{
    
    function getUser() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $username = Input::get('agent');
                if(!empty($username)) {
                    $result = users_model::getUserByUsername($username);
                    if($result) {
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "User Found successfully", 'data' => $result,  ];
                    } else {
                        http_response_code(404); // Not Found
                        $response = ["status" => 0, "message" => "User not found"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Username is required"];
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

    function updateBankInfo() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $username = $auth;
                $account_number = Input::post('account_number');
                $bank = Input::post('bank');
                if(!empty($username) && !empty($account_number) && !empty($bank) ) {
                    $user_id = users_model::getUserByUsername($username)["id"];
                    $result = users_model::updateBankInfo($user_id, $account_number, $bank);
                    if($result) {
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Bank info updated successfully"];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to update bank info"];
                    }                  
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Account number and bank name are required"];
                }
            } else {
                http_response_code(400); // Bad Request
                $response = ["status" => 0, "message" => "UnAuthorized"];
            }
        } else {
            http_response_code(405); // Method Not Allowed
            $response = ["status" => 0, "message" => "Method not allowed"];
        }
        echo  json_encode($response);
    } 

    function changePassword() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            if ($auth) {
                $username = $auth;
                $old_password = Input::post('old_password');
                $new_password = Input::post('new_password');
    
                // Validate input
                if (!empty($username) && !empty($new_password) && !empty($old_password)) {
                    // Change the password
                    $currentPass = users_model::getUserByPassword($username)["password"];
                    if($old_password != $currentPass) {
                        http_response_code(400); // Bad Request
                        $response = [
                            "status" => 0,
                            "message" => "Old password is incorrect"
                        ];
    
                    } else {
                        $result = users_model::changePassword($username, $new_password);
                        if ($result) {
                            // Regenerate the JWT token after password change
                            $user = users_model::getUserByUsername($username);
                            $new_token = auth_model::regenerateToken($user);
        
                            if ($new_token) {
                                http_response_code(200); // OK
                                $response = [
                                    "status" => 1,
                                    "message" => "Password updated successfully",
                                    "token" => $new_token // Return the new token to the client
                                ];
                            } else {
                                http_response_code(500); // Internal Server Error
                                $response = [
                                    "status" => 0,
                                    "message" => "Password updated, but failed to regenerate token"
                                ];
                            }
                        } else {
                            http_response_code(400); // Bad Request
                            $response = [
                                "status" => 0,
                                "message" => "Failed to update password"
                            ];
                        }
                    }  
                  
                } else {
                    http_response_code(400); // Bad Request
                    $response = [
                        "status" => 0,
                        "message" => "New password & New password are required"
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

    

}