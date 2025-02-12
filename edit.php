<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require_once "database.php";

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch user data
$sql = "SELECT first_name, last_name, email, mobile_no, file_path FROM userdata WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile_phone = $_POST['mobile_no'];
    $email = $_POST['email'];
    
    $uploadOk = 1;
    $file_name = "";
    $file_path = $user['file_path']; // Keep existing file unless updated

    if (!empty($_FILES['file']['name'])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["file"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = ["pdf", "doc", "docx", "txt"];

        if (!in_array($file_type, $allowed_types)) {
            $message = "Error: Only PDF, DOC, DOCX, and TXT files are allowed.";
            $uploadOk = 0;
        } elseif ($_FILES["file"]["size"] > 5000000) {
            $message = "Error: File is too large (Max: 5MB).";
            $uploadOk = 0;
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $file_path = $target_file; // Update file path
            } else {
                $message = "Error uploading file.";
                $uploadOk = 0;
            }
        }
    }

    if ($uploadOk) {
        $stmt = $connection->prepare("UPDATE userdata SET first_name = ?, last_name = ?, mobile_no = ?, email = ?, file_path = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $first_name, $last_name, $mobile_phone, $email, $file_path, $user_id);

        if ($stmt->execute()) {
            $message = "User data updated successfully.";
        } else {
            $message = "Error updating record: " . $connection->error;
        }
        
        $stmt->close();
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Style CSS -->
    
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>

    <div class="container">
        <h2>Edit Profile</h2>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="edit.php" method="POST" enctype="multipart/form-data" class="form">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="mobile_no">Phone Number:</label>
            <input type="text" id="mobile_no" name="mobile_no" value="<?php echo htmlspecialchars($user['mobile_no']); ?>" required>

            <label for="file">Upload Document:</label>
            <input type="file" name="file" id="file">

            <?php if (!empty($user['file_path'])): ?>
                <div class="file-preview">
                    <p>Current Document: <a href="<?php echo $user['file_path']; ?>" target="_blank">View Document</a></p>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn">Update Profile</button>
        </form>

        <a href="dashboard.php" class="btn">Back to Dashboard</a>
        <a href="delete.php" class="delete-btn" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone!');">Delete My Account</a>
    </div>

</body>
</html>
