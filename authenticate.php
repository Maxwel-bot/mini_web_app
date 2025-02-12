// login.php
<?php
session_start();
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT id, password FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        // Redirect to customer form
        echo "
        <script>
            alert('Login Successfully!');
            window.location.href = 'http://localhost/task/dashboard.php';
        </script>
        "; 
    } else {
        echo "
        <script>
            alert('Login Failed, Incorrect Password!');
            window.location.href = 'http://localhost/task/login.php';
        </script>
        ";
    }
} else {
    echo "
        <script>
            alert('Login Failed, User Not Found!');
            window.location.href = 'http://localhost/task/login.php';
        </script>
        ";

    $stmt->close();
}

$connection->close();
?>