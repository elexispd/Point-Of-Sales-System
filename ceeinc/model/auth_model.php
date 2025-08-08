
<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class auth_model extends ceemain{
    
    static function authorize() {
        $headers = getallheaders();
        $tokenHeader = $headers['Authorization'] ?? '';
        $token = str_replace('Bearer ', '', $tokenHeader);    
        try {
            // Decode the token
            $decoded = JWT::decode($token, new Key(SECRET_KEY, ALGORITHM));
    
            // Check if the token has expired
            if (isset($decoded->exp) && $decoded->exp >= time()) {
                // Token is valid, return the username
                return $decoded->email;
            } else {
                // Token has expired
                return false;
            }
        } catch (\Exception $e) {
            // Invalid token
            return false;
        }
    }

    static function generateToken($user) {
        // JWT payload
        $payload = [
            "user_id" => $user["id"],
            "email" => $user["email"],
            "exp" => time() + (2 * 60 * 60) // 2 hours expiration
        ];

        // Generate and return the JWT token
        return JWT::encode($payload, SECRET_KEY, ALGORITHM);
    }


    static function regenerateToken($username) {
        // Generate a new JWT token
        $new_token = self::generateToken($username);
        return $new_token;
    }

}