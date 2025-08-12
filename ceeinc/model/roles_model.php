<?php

class roles_model extends ceemain{


    public static function store($name) {
        $key = configurations::systemkey();
        $date = date("YmdHis", time());
        $sql = "INSERT INTO roles 
                SET name = AES_ENCRYPT('".$name."','".$key."'), 
                    status = AES_ENCRYPT('1','".$key."'), 
                    created_at = AES_ENCRYPT('".$date."','".$key."')";
        
        $conn = db::createion();
        $result = $conn->query($sql);

        if ($result === true) {
            return $conn->insert_id;
        } else {
            error_log("Database error: " . $conn->error);
            return false; 
        }
    }
    
    public static function getRoles() { 
        $key = configurations::systemkey();
        $conn = db::createion();

        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS role,
                    AES_DECRYPT(status, '".$key."') AS status
                FROM roles";
        $result = $conn->query($sql);

        if ($result) {
            $roles = [];
            while ($row = $result->fetch_assoc()) {
                $roleId = $row['id'];

                //Get permissions for this role
                $permSql = "SELECT AES_DECRYPT(p.name, '".$key."') AS name
                            FROM role_permission rp
                            INNER JOIN permissions p 
                                ON p.id = CAST(AES_DECRYPT(rp.permission_id, '".$key."') AS UNSIGNED)
                            WHERE CAST(AES_DECRYPT(rp.role_id, '".$key."') AS UNSIGNED) = '".$roleId."'";
                $permResult = $conn->query($permSql);

                $permissions = [];
                if ($permResult) {
                    while ($permRow = $permResult->fetch_assoc()) {
                        $permissions[] = $permRow['name'];
                    }
                }

                // Attach permissions array to role
                $roles[] = [
                    "id" => $roleId,
                    "role" => $row['role'],
                    "permissions" => $permissions
                ];
            }
            return $roles;
        } else {
            return [];
        }
    }

    

    public static function getRoleById($id) {
        $key = configurations::systemkey();
        $conn = db::createion();

        // Fetch role details
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS role,
                    AES_DECRYPT(status, '".$key."') AS status
                FROM roles 
                WHERE id = '".intval($id)."'";
        $result = $conn->query($sql);

        if ($result && $role = $result->fetch_assoc()) {
            // Fetch permissions for this role
            $permSql = "SELECT AES_DECRYPT(p.name, '".$key."') AS name
                        FROM role_permission rp
                        INNER JOIN permissions p 
                            ON p.id = CAST(AES_DECRYPT(rp.permission_id, '".$key."') AS UNSIGNED)
                        WHERE CAST(AES_DECRYPT(rp.role_id, '".$key."') AS UNSIGNED) = '".intval($id)."'";
            $permResult = $conn->query($permSql);

            $permissions = [];
            if ($permResult) {
                while ($permRow = $permResult->fetch_assoc()) {
                    $permissions[] = $permRow['name'];
                }
            }

            // Attach permissions
            $role['permissions'] = $permissions;
            return $role;
        }

        return null; // No role found
}



    static function updateRoleStatus($id, $status) {
        $key = configurations::systemkey();
        $sql = "UPDATE roles 
                SET status =  AES_ENCRYPT('".$status."','".$key."')
                WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    static function changeName($id, $name) {
        $key = configurations::systemkey();
        $sql = "UPDATE roles SET name = AES_ENCRYPT('".$name."','".$key."') WHERE id = $id";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result;
    }

    static function getTotalRoles() {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    COUNT(*) AS total_roles
                FROM roles";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    static function isRoleExist($name) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id,
                    AES_DECRYPT(name, '".$key."') AS name
                FROM roles 
                WHERE name = AES_ENCRYPT('".$name."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows;
    }
    static function isRolePermissionExist($role_id, $permission_id) {
        $key = configurations::systemkey();
        $sql = "SELECT 
                    id
                FROM role_permission 
                WHERE role_id = AES_ENCRYPT('".$role_id."','".$key."')
                AND permission_id = AES_ENCRYPT('".$permission_id."','".$key."')"; 
        $conn = db::createion();
        $result = $conn->query($sql);
        return $result->num_rows;
    }

    public static function storeRolePermission($role_id, $permission_id) {
        $key = configurations::systemkey();
        $sql = "INSERT INTO role_permission 
                SET 
                    role_id = AES_ENCRYPT('".$role_id."','".$key."'), 
                    permission_id = AES_ENCRYPT('".$permission_id."','".$key."')";
        $conn = db::createion();
        $result = $conn->query($sql);
    
        if ($result === true) {
            return 1;
        } else {
            return $conn->error; 
        }
    }  

    public static function getPermissionIdsByRole($role_id) {
        $key = configurations::systemkey();
        $sql = "SELECT CAST(AES_DECRYPT(permission_id, '".$key."') AS UNSIGNED) AS perm_id
                FROM role_permission
                WHERE CAST(AES_DECRYPT(role_id, '".$key."') AS UNSIGNED) = '".intval($role_id)."'";
        $conn = db::createion();
        $result = $conn->query($sql);

        $permissions = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $permissions[] = $row['perm_id'];
            }
        }
        return $permissions;
    }

    public static function removeRolePermission($role_id, $permission_id) {
        $key = configurations::systemkey();
        $sql = "DELETE FROM role_permission
                WHERE role_id = AES_ENCRYPT('".$role_id."','".$key."')
                AND permission_id = AES_ENCRYPT('".$permission_id."','".$key."')";
        $conn = db::createion();
        return $conn->query($sql);
    }







}