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
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $name = Input::post('name');
                $email = Input::post('email');
                $role = Input::post('role');
                $password = Input::post('password');
                $phone = Input::post('phone');

       
                if(!empty($role) && !empty($email) && !empty($password) && !empty($phone) && !empty($name) ) {
                    $is_exit = users_model::getUserByEmail($email);
                    if(!empty($is_exit)) {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Email already exists"];
                        echo json_encode($response);
                        return;
                    }
  
                    $result = users_model::store($name, $email, $phone, $role, $password);
                    $user = [
                        "id" => $result,
                        "name" => $name,
                        "email" => $email,
                        "phone" => $phone,
                        "role" => $role
                    ];
                    if($result) {
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "User created successfully", 'data' => $user];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to create user"];
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
    function getUser() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $id = Input::get('id');
                if(!empty($id)) {
                    $result = users_model::getUserById($id);
                    if($result) {
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "User Found successfully", 'data' => $result];
                    } else {
                        http_response_code(404); // Not Found
                        $response = ["status" => 0, "message" => "User not found"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "ID is required"];
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

    function changePassword() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            if ($auth) {
                $email = $auth;
                $old_password = Input::post('old_password');
                $new_password = Input::post('new_password');
    
                // Validate input
                if (!empty($email) && !empty($new_password) && !empty($old_password)) {
                    // Change the password
                    $currentPass = users_model::getUserByPassword($email)["password"];
                    if($old_password != $currentPass) {
                        http_response_code(400); // Bad Request
                        $response = [
                            "status" => 0,
                            "message" => "Old password is incorrect"
                        ];
    
                    } else {
                        $result = users_model::changePassword($email, $new_password);
                        if ($result) {
                            // Regenerate the JWT token after password change
                            $user = users_model::getUserByEmail($email);
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