<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
require_once "../database.php"; // Ensure correct path
require_once "jwt_helper.php"; // Ensure this file exists

// Read raw input
$raw_input = file_get_contents("php://input");
$input = json_decode($raw_input, true);

// Debugging: Print raw input
if (!$input) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON format",
        "raw_input" => $raw_input
    ]);
    exit();
}

// Check if email and password exist in the request
if (!isset($input['email']) || !isset($input['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing email or password",
        "received" => $input
    ]);
    exit();
}

$email = $input['email'];
$password = $input['password'];

// Prepare SQL statement
$sql = "SELECT id, password FROM userdata WHERE email = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $id = $row['id']; 

        // Generate JWT Token
        $token = JWTAuth::generateToken($id); 

        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "token" => $token
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
$connection->close();
?>
