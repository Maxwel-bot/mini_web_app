<?php
require __DIR__ . "/../database.php";
require "jwt_helper.php";

header("Content-Type: application/json");

// Get token from headers
$headers = getallheaders();
$token = isset($headers['Authorization']) ? str_replace("Bearer ", "", $headers['Authorization']) : null;

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

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["id"], $data["first_name"], $data["last_name"], $data["email"], $data["mobile_no"])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit();
}

$customer_no = intval($data["id"]); 
$first_name = trim($data["first_name"]);
$last_name = trim($data["last_name"]);
$full_name = $first_name . " " . $last_name; // Combine first & last name
$email = trim($data["email"]);
$phone = trim($data["mobile_no"]);

// Update customer record
$sql = "UPDATE userdata SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $customer_no);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Customer updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update customer"]);
}

$stmt->close();
$connection->close();
?>
