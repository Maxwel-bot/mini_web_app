<?php
require __DIR__ . "/../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

class JWTAuth {
    private static $secret_key;
    private static $algorithm = "HS256";
    private static $initialized = false;

    // Load the secret key from .env (only once)
    public static function init() {
        if (self::$initialized) {
            return;
        }
        self::$initialized = true;

        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        self::$secret_key = $_ENV['JWT_SECRET'] ?? null;

        if (!self::$secret_key) {
            throw new Exception("JWT secret key is missing in .env file.");
        }
    }

    // Generate JWT Token
    public static function generateToken($user_id) {
        self::init();
        $payload = [
            "iss" => "localhost", // Issuer
            "iat" => time(), // Issued at
            "exp" => time() + (60 * 60), // Expiration (1 hour)
            "user_id" => $user_id
        ];
        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    // Validate JWT Token
    public static function validateToken($jwt) {
        self::init();
        try {
            return JWT::decode($jwt, new Key(self::$secret_key, self::$algorithm));
        } catch (Exception $e) {
            return ["error" => $e->getMessage()]; // Debugging
        }
    }
    
}
?>
