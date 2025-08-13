<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class auth_api extends ceemain
{
    

    /**
     * Handle user login
     */
    public function login()
    {
        $response = [];

        // Check request method
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $response = ["status" => 0, "message" => "Invalid request method"];
            echo json_encode($response);
            return;
        }

        // Validate input
        $username = Input::post("email");
        $password = Input::post("password");

        if (empty($username) || empty($password)) {
            $response = ["status" => 0, "message" => "Email and password are required"];
            echo json_encode($response);
            return;
        }

        // Authenticate user
        $result = users_model::auth($username, $password);


        if ($result != false) {
            // Fetch user details
            $user = users_model::getUserByEmail($username);
            
            if($user["status"] == 1) {
                $token = auth_model::generateToken($user);
                $response = [
                    "status" => 1,
                    "message" => "Login successful",
                    "token" => $token,
                    "data" => $user
                ];
            } else {
                // user is not active
                $response = [
                    "status" => 1,
                    "message" => "Account Suspended... Please Contact The Administrator.",
                ];
            }

            
        } else {
            // Return error response
            $response = [
                "status" => 0,
                "message" => "Invalid credentials"
            ];
        }

        echo json_encode($response);
    }
}