<?php
session_start();
require_once "database.php";

// Check if an ID is provided in the URL
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$user_id_to_delete = intval($_GET['id']); // Sanitize input
$logged_in_user_id = $_SESSION['user_id']; // Get current session user ID

// Prepare delete query
$stmt = $connection->prepare("DELETE FROM userdata WHERE id = ?");
$stmt->bind_param("i", $user_id_to_delete);
$success = $stmt->execute();
$stmt->close();

if ($success) {
    // If the logged-in user deletes their own account, log them out
    if ($user_id_to_delete === $logged_in_user_id) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    // If another user is deleted, just return to dashboard
    header("Location: dashboard.php?msg=User deleted successfully");
    exit();
} else {
    echo "Error deleting user.";
}
?>
