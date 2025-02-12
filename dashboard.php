<?php
session_start();
require_once "database.php";

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Secure File Handling (View & Download)
if (isset($_GET['action']) && isset($_GET['file'])) {
    $action = $_GET['action'];
    $file_path = realpath($_GET['file']); // Get absolute path
    $allowed_dir = realpath("uploads/"); // Restrict files to the uploads directory

    if (strpos($file_path, $allowed_dir) !== 0 || !file_exists($file_path)) {
        die("File not found or access denied.");
    }

    $file_name = basename($file_path);
    $mime_type = mime_content_type($file_path);

    if ($action === "view") {
        header("Content-Type: $mime_type");
        header("Content-Disposition: inline; filename=\"$file_name\"");
        readfile($file_path);
        exit();
    } elseif ($action === "download") {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$file_name\"");
        readfile($file_path);
        exit();
    }
}

// Fetch all users from the database
$stmt = $connection->prepare("SELECT id, first_name, last_name, email, mobile_no, file_name, file_path FROM userdata");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background-color: #343a40 !important;
            color: white !important;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 5px;
        }
        .btn-view {
            background-color: #28a745;
            color: white;
        }
        .btn-edit {
            background-color: #007bff;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-logout {
            background-color: #ff9800;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center text-primary mb-4">User Dashboard</h2>

        <div class="table-container">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Uploaded File</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['mobile_no']); ?></td>
                            <td>
                                <?php if (!empty($user['file_name'])): ?>
                                    <a href="dashboard.php?action=view&file=<?php echo urlencode($user['file_path']); ?>" class="btn btn-view btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="dashboard.php?action=download&file=<?php echo urlencode($user['file_path']); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                <?php else: ?>
                                    No File
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-edit btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete.php?id=<?php echo $user['id']; ?>" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

</body>
</html>

<?php
$connection->close();
?>
