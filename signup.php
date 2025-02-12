<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup | My PHP Site</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">My PHP Site</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link active" href="signup.php">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Signup Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h2 class="text-center">Create an Account</h2>
                    <form action="add-user.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Enter your first name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Enter your last name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mobile No.</label>
                            <input type="text" name="mobile_no" class="form-control" placeholder="Enter your mobile number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload CV (PDF/DOCX)</label>
                            <input type="file" name="cv" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-light text-center py-4 mt-5">
        <div class="container">
            <p class="mb-1">&copy; 2025 My PHP Site. All rights reserved.</p>
            <p>
                <a href="#" class="text-light me-3">Privacy Policy</a>
                <a href="#" class="text-light">Terms of Service</a>
            </p>
            <div class="mt-2">
                <a href="#" class="text-light me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-light me-3"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-light"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
