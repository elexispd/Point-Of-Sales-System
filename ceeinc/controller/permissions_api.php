<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class permissions_api extends ceemain
{
    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();            
            if ($auth) {
                $name = Input::post('name');   
                $name = strtolower($name); 
                if(!empty($name) ) {
                    $is_exit = permissions_model::isPermissionExist($name);

                    if($is_exit > 0) {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Permissions already exists"];
                        echo json_encode($response);
                        return;
                    }
                    $result = permissions_model::store($name);

                    if($result) {
                        http_response_code(201); // Created
                        $response = ["status" => 1, "message" => "Permissions created successfully", 'data' => $name];
                        $user_id = users_model::getUserByEmail($auth)['id'];
                        $action = 'Create Permission';
                        $desc= 'Added permission of name: ' . $name;
                        logs_model::activity_log($user_id, $action, $desc);
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to create Permissions"];
                        $user_id = users_model::getUserByEmail($auth)['id'];
                        $action = 'Create Permission';
                        $desc= 'Failed to add permission of name: ' . $name;
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
   
    function getAllPermissions() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = permissions_model::getPermissions();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Permissionss Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Permissions not found"];
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

    function getPermissionById()
    {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $id = Input::get('permission_id');
                if(!empty($id)) {
                    $result = permissions_model::getPermissionById($id);
                    if($result) {
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Permissions Found successfully", 'data' => $result];
                    } else {
                        http_response_code(404); // Not Found
                        $response = ["status" => 0, "message" => "No Permissions found"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Permission ID is required"];
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
                $id = Input::post('permission_id');
                $status = Input::post('status');

                if(! (empty($id) && empty($status))) {
                    $result = permissions_model::updatePermissionStatus($id, $status);
                    
                    if($result) {
                        $user_id = users_model::getUserByEmail($auth)['id'];
                        $action = 'Update Permission Status';
                        
                        if($status ==1) {
                            $statusMessage = "activated";
                            $desc= 'Activated permission to: ' . $statusMessage;
                            logs_model::activity_log($user_id, $action, $desc);
                        } elseif($status == 0) {
                            $statusMessage = "deactivated";
                            $desc= 'Disactivated permission to: ' . $statusMessage;
                            logs_model::activity_log($user_id, $action, $desc);
                        } else {
                            http_response_code(400); // Bad Request
                            $response = ["status" => 0, "message" => "Invalid status value"];
                            echo json_encode($response);
                            $desc= 'Failed to activate/deactive permission of id: ' . $id;
                            logs_model::activity_log($user_id, $action, $desc);
                            return;
                        }
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Permissions status $statusMessage successfully"];

                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to update Permissions status"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Permissions ID and status are required"];
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

    function changePermissionName() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            if ($auth) {
                $email = $auth;
                $name = Input::post('name');
                $id = Input::post('permission_id');
                $user_id = users_model::getUserByEmail($auth)['id'];
                $result = permissions_model::changeName($id, $name);
                if ($result) {
                    // Regenerate the JWT token after password change
                    $Permissions = permissions_model::getPermissionById($id);
                    http_response_code(200); // OK
                    $response = [
                        "status" => 1,
                        "message" => "Permissions Name updated successfully",
                        "data" => $Permissions 
                    ];

                    $desc= 'Changed permission name to: ' . $name;
                    $action = "change Permission Name";
                    logs_model::activity_log($user_id, $action, $desc);
                    
                } else {
                    http_response_code(400); // Bad Request
                    $response = [
                        "status" => 0,
                        "message" => "Failed to update Permissions"
                    ];
                    $desc= 'Failed to change permission name to: ' . $name;
                    $action = "Change Permission Name";
                    logs_model::activity_log($user_id, $action, $desc);
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

    function getTotalPermissions()
    {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = permissions_model::getTotalPermissions();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Total Permissions Found successfully", 'data' => $result];
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