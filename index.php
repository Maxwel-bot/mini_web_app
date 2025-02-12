<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | My PHP Site</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    </style>
    <link rel="stylesheet" href="css/index.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Slideshow and Short Message -->
    <div class="container mt-5">
        <div class="content-section">
            <!-- Slideshow -->
            <div class="carousel-container">
                <div id="carouselExample" class="carousel slide mx-auto" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="images/img1.jpg" class="d-block w-100" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img src="images/img4.jpg" class="d-block w-100" alt="Slide 2">
                        </div>
                        <div class="carousel-item">
                            <img src="images/img5.jpg" class="d-block w-100" alt="Slide 3">
                        </div>
                        <div class="carousel-item">
                            <img src="images/img6.jpg" class="d-block w-100" alt="Slide 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <!-- Short Message -->
            <div class="content-text">
                <h2>Discover Endless Possibilities</h2>
                <p>
                    Whether you're here to learn, grow, or connect, we have something special for you. Explore our services and get started today!
                </p>
                <a href="services.php" class="btn btn-custom">Explore Services</a>
            </div>
        </div>
    </div>
     <!-- Footer -->
     <footer class="footer bg-dark text-light text-center py-4 mt-5">
        <div class="container">
            <p class="mb-1">&copy; 2025 My PHP Site. All rights reserved.</p>
            <p class="mb-0">
                <a href="#" class="text-light me-3">Privacy Policy</a>
                <a href="#" class="text-light">Terms of Service</a>
            </p>
            <div class="social-icons mt-2">
                <a href="#" class="text-light me-2"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-light me-2"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-light me-2"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </footer>


    <!-- JavaScript to Auto-Slide the Carousel Every 10 Seconds -->
    <script>
        function showSlides() {
            let myCarousel = new bootstrap.Carousel(document.querySelector("#carouselExample"), {
                interval: 10000 // Auto slide every 10 seconds
            });
        }
        setTimeout(showSlides, 1000);
    </script>

</body>
</html>
