<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once "database.php";

// Get input values and trim whitespace
$firstName = trim($_POST['first_name']);
$lastName = trim($_POST['last_name']);
$contactNumber = trim($_POST['mobile_no']);
$email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_BCRYPT); // Secure password hashing


$file_name = null;
$file_path = null;

// Check if the email already exists
$emailCheckStmt = $connection->prepare("SELECT email FROM userdata WHERE email = ?");
$emailCheckStmt->bind_param("s", $email);
$emailCheckStmt->execute();
$emailCheckStmt->store_result();

if ($emailCheckStmt->num_rows > 0) {
    echo "<script>alert('Error: Email already exists!'); window.location.href = 'signin.php';</script>";
    exit();
}
$emailCheckStmt->close();


if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] == 0) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/"; // Ensure correct path

    // Create uploads directory if not exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_tmp = $_FILES["cv"]["tmp_name"];
    $file_name = basename($_FILES["cv"]["name"]); // Keep original filename
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ["pdf", "doc", "docx", "txt"];

    if (in_array($file_type, $allowed_types)) {
        $file_path = $target_dir . $file_name; // Full file path

        
        if (file_exists($file_path)) {
            $file_name = pathinfo($file_name, PATHINFO_FILENAME) . "_" . time() . "." . $file_type;
            $file_path = $target_dir . $file_name;
        }

        if (move_uploaded_file($file_tmp, $file_path)) {
            echo "<script>alert('✅ File uploaded successfully!');</script>";
        } else {
            error_log("File upload failed: " . print_r(error_get_last(), true));
            echo "<script>alert('❌ Error: Could not move the uploaded file.');</script>";
        }
    } else {
        echo "<script>alert('❌ Error: Only PDF, DOC, DOCX, and TXT files are allowed.');</script>";
    }
}

// ✅ Insert user details into database
try {
    $stmt = $connection->prepare("INSERT INTO userdata (first_name, last_name, mobile_no, email, password, file_name, file_path) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstName, $lastName, $contactNumber, $email, $hashed_password, $file_name, $file_path);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Registered Successfully!'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('❌ Database Insert Error: " . addslashes($stmt->error) . "'); window.location.href = 'signup.php';</script>";
    }

    $stmt->close();
    $connection->close();

} catch (mysqli_sql_exception $e) {
    echo "<script>alert('❌ Database Error: " . addslashes($e->getMessage()) . "'); window.location.href = 'signup.php';</script>";
}
?>
