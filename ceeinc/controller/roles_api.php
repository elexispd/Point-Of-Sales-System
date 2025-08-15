<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class roles_api extends ceemain
{
    

    
    function create() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = auth_model::authorize();            
            if (!$auth) {
                http_response_code(401);
                echo json_encode(["status" => 0, "message" => "Unauthorized"]);
                return;
            }

            $action = "Create Roles";
            $user_id = users_model::getUserByEmail($auth)['id'];  

            $name = strtolower(trim(Input::post('name')));
            $permissions = $_POST["permissions"]; // array of permission IDs

            // Permission is compulsory
            if (!is_array($permissions) || empty($permissions)) {
                http_response_code(400);
                echo json_encode(["status" => 0, "message" => "At least one permission is required"]);
                return;
            }

            if (empty($name)) {
                http_response_code(400);
                echo json_encode(["status" => 0, "message" => "Role name is required"]);
                return;
            }

            if (roles_model::isRoleExist($name) > 0) {
                http_response_code(400);
                echo json_encode(["status" => 0, "message" => "Role already exists"]);
                return;
            }

            

            $conn = db::createion();
            $conn->begin_transaction();

            try {
                $role_id = roles_model::store($name); // return ID 
                if (!$role_id) {
                    throw new Exception("Failed to create role");
                }

                foreach ($permissions as $perm_id) {
                    if (!permissions_model::isPermissionExistById($perm_id)) {
                        throw new Exception("Permission with ID $perm_id does not exist");
                    }

                    //Skip if role-permission already exists
                    if (!roles_model::isRolePermissionExist($role_id, $perm_id)) {
                        if (!roles_model::storeRolePermission($role_id, $perm_id)) {
                            throw new Exception("Failed to assign permission ID $perm_id");
                        }
                    }
                }

                $conn->commit();
                http_response_code(201);
                $response = ["status" => 1, "message" => "Role and permissions created successfully"];

                $desc= 'Added role of name: ' . $name;                    
                logs_model::activity_log($user_id, $action, $desc);
            } catch (Exception $e) {
                $conn->rollback();
                http_response_code(400);
                $response = ["status" => 0, "message" => $e->getMessage()];
                $desc= 'Failed To add role of name: ' . $name;                    
                logs_model::activity_log($user_id, $action, $desc);
            }

            echo json_encode($response);
        }
    }

   
    function getAllRoles() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = roles_model::getRoles();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Roles Retrieved successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "Role not found"];
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

    function getRoleById()
    {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $id = Input::get('role_id');
                if(!empty($id)) {
                    $result = roles_model::getRoleById($id);
                    if($result) {
                        http_response_code(200); // OK
                        $response = ["status" => 1, "message" => "Role Found successfully", 'data' => $result];
                    } else {
                        http_response_code(404); // Not Found
                        $response = ["status" => 0, "message" => "No role found"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Role is required"];
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
                $id = Input::post('role_id');
                $status = Input::post('status');

                if(! (empty($id) && empty($status))) {
                    $result = roles_model::updateRoleStatus($id, $status);
                    
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
                        $response = ["status" => 1, "message" => "Role status $statusMessage successfully"];
                    } else {
                        http_response_code(400); // Bad Request
                        $response = ["status" => 0, "message" => "Failed to update role status"];
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["status" => 0, "message" => "Role ID and status are required"];
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

    function changeRoleName() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Authorize the request
            $auth = auth_model::authorize();
            if ($auth) {
                $email = $auth;
                $name = Input::post('name');
                $id = Input::post('role_id');

                $result = roles_model::changeName($id, $name);
                if ($result) {
                    // Regenerate the JWT token after password change
                    $role = roles_model::getRoleById($id);
                    http_response_code(200); // OK
                    $response = [
                        "status" => 1,
                        "message" => "Role Name updated successfully",
                        "data" => $role 
                    ];
                    
                } else {
                    http_response_code(400); // Bad Request
                    $response = [
                        "status" => 0,
                        "message" => "Failed to update role"
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

    function getTotalRoles()
    {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {
                $result = roles_model::getTotalRoles();
                if($result) {
                    http_response_code(200); // OK
                    $response = ["status" => 1, "message" => "Total Role Found successfully", 'data' => $result];
                } else {
                    http_response_code(404); // Not Found
                    $response = ["status" => 0, "message" => "No Role found"];
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

    function edit() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = auth_model::authorize();
            if (!$auth) {
                http_response_code(401);
                echo json_encode(["status" => 0, "message" => "Unauthorized"]);
                return;
            }

            $id = intval(Input::post('role_id'));
            $name = strtolower(trim(Input::post('name')));
            $permissions = $_POST['permissions']; // array or null

            $existingRole = roles_model::getRoleById($id);
            if (!$existingRole) {
                http_response_code(404);
                echo json_encode(["status" => 0, "message" => "Role not found"]);
                return;
            }

            $conn = db::createion();
            $conn->begin_transaction();
            
            $action = "Change Role";
            $user_id = users_model::getUserByEmail($auth)['id'];  

            try {
                if (!empty($name) && $name !== strtolower($existingRole['role'])) {
                    if (roles_model::isRoleExist($name) > 0) {
                        throw new Exception("Role name already exists");
                    }
                    if (!roles_model::changeName($id, $name)) {
                        throw new Exception("Failed to update role name");
                    }
                }

                if (is_array($permissions)) {
                    foreach ($permissions as $perm_id) {
                        if (!permissions_model::isPermissionExistById($perm_id)) {
                            throw new Exception("Permission with ID $perm_id does not exist");
                        }
                    }

                    $currentPerms = roles_model::getPermissionIdsByRole($id);

                    $toRemove = array_diff($currentPerms, $permissions);
                    foreach ($toRemove as $perm_id) {
                        roles_model::removeRolePermission($id, $perm_id);
                    }

                    $toAdd = array_diff($permissions, $currentPerms);
                    foreach ($toAdd as $perm_id) {
                        roles_model::storeRolePermission($id, $perm_id);
                    }
                }

                $conn->commit();
                http_response_code(200);
                $response = ["status" => 1, "message" => "Role updated successfully"];

                $desc= 'Changed role of name: ' . $name;                    
                logs_model::activity_log($user_id, $action, $desc);

            } catch (Exception $e) {
                $conn->rollback();
                http_response_code(400);
                $response = ["status" => 0, "message" => $e->getMessage()];
                $desc= 'Changed role of name: ' . $name;                    
                logs_model::activity_log($user_id, $action, $desc);
            }

            echo json_encode($response);
        }
    }


 
    

}