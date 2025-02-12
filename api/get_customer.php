<?php
require __DIR__ . "/../database.php";
require "jwt_helper.php";

header("Content-Type: application/json");

// Get token from headers (Case-insensitive)
$headers = getallheaders();
$authHeader = array_change_key_case($headers, CASE_LOWER); // Normalize header keys
$token = isset($authHeader['authorization']) ? str_replace("Bearer ", "", $authHeader['authorization']) : null;

if (!$token) {
    echo json_encode(["status" => "error", "message" => "No token provided"]);
    exit();
}

// Validate token
$decoded = JWTAuth::validateToken($token);
if (!$decoded) {
    echo json_encode(["status" => "error", "message" => "Invalid token"]);
    exit();
}

// Check if customer_id is provided
if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "Customer ID is required"]);
    exit();
}

$customer_id = intval($_GET['id']); // Use correct key

// Fetch customer data (Using first_name and last_name separately)
$sql = "SELECT id, first_name, last_name, email, mobile_no FROM userdata WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$decoded = JWTAuth::validateToken($token);
if (isset($decoded['error'])) {
    echo json_encode(["status" => "error", "message" => "Invalid token", "error" => $decoded['error']]);
    exit();
}


if ($data = $result->fetch_assoc()) {
    echo json_encode([
        "status" => "success",
        "customer" => [
            "id" => $data['id'],
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            "phone" => $data['phone']
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Customer not found"]);
}

$stmt->close();
$connection->close();
?>
