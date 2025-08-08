<?php




class Security{
	
    private static $encryption_key = 'this_is_a_16_byte_key'; // Ensure 16 or 32 bytes based on cipher
    private static $cipher = 'AES-128-CBC';
    private static $iv_length;

    public static function init() {
        self::$iv_length = openssl_cipher_iv_length(self::$cipher);
    }

    public static function encrypt($data) {
        self::init();
        $iv = openssl_random_pseudo_bytes(self::$iv_length); // Generate IV
        $encrypted = openssl_encrypt($data, self::$cipher, self::$encryption_key, 0, $iv);
        $encrypted = base64_encode($iv . $encrypted); // Combine IV and encrypted value, encode in base64

        // Make the encrypted string URL-safe
        $urlSafeEncrypted = str_replace(['+', '/', '='], ['-', '_', ''], $encrypted);

        return $urlSafeEncrypted;
    }

    public static function decrypt($encryptedData) {
        self::init();

        // Revert the URL-safe string back to its original form
        $encryptedData = str_replace(['-', '_'], ['+', '/'], $encryptedData);
        
        // Decode the base64 string
        $data = base64_decode($encryptedData);

        // Extract the IV and encrypted part
        $iv = substr($data, 0, self::$iv_length); 
        $encrypted = substr($data, self::$iv_length); 

        // Decrypt the data
        return openssl_decrypt($encrypted, self::$cipher, self::$encryption_key, 0, $iv);
    }


    
	
	
	
}



