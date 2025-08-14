<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');



class dashboard_api extends ceemain
{
    

   
    function getTotalReport() {
        $response = [];
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Authorize the request
            $auth = auth_model::authorize();
            
            if ($auth) {


                $type = Input::get('type');

                $totalProducts = products_model::getTotalProducts();
                $totalSales = sales_model::getTotalSales();
                $totalUsers = users_model::getTotalUsers();
                $result = [
                    'total_products' => $totalProducts,
                    'total_sales' => $totalSales,
                    'total_users' => $totalUsers,
                    'orders' => []
                ];
                http_response_code(200); // OK
                $response = ["status" => 1, "message" => "Data Retrieved successfully", 'data' => $result];            
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