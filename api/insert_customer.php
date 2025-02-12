<?php
require_once "../database.php"; 
// Ensure correct path
require __DIR__ . "/jwt_helper.php";

header("Content-Type: application/json");

// Get token from headers
$headers = apache_request_headers();
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

// Check if form data is sent via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}

// Get input data from POST request
$first_name = $_POST["first_name"] ?? "";
$last_name = $_POST["last_name"] ?? "";
$email = $_POST["email"] ?? "";
$phone = $_POST["mobile_no"] ?? "";
$file_path = "";

// Check required fields
if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit();
}

// File upload handling
$uploadOk = 1;
if (!empty($_FILES['file']['name'])) {
    $target_dir = "../uploads/";  // Ensure the folder exists
    $file_name = time() . "_" . basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ["pdf", "doc", "docx", "txt"];

    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(["status" => "error", "message" => "Invalid file type. Only PDF, DOC, DOCX, and TXT are allowed."]);
        $uploadOk = 0;
    } elseif ($_FILES["file"]["size"] > 5000000) {
        echo json_encode(["status" => "error", "message" => "File is too large (Max: 5MB)."]);
        $uploadOk = 0;
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $file_path = $target_file; // Store file path
        } else {
            echo json_encode(["status" => "error", "message" => "Error uploading file"]);
            $uploadOk = 0;
        }
    }
}

// Insert new customer into database if file upload is okay
if ($uploadOk) {
    $sql = "INSERT INTO userdata (first_name, last_name, email, mobile_no, file_path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $file_path);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Customer added successfully",
            "customer_id" => $stmt->insert_id
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to insert customer"]);
    }

    $stmt->close();
}

$connection->close();
?>
