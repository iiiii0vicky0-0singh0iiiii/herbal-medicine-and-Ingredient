<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include or require the database connection file
    require_once __DIR__ . "/database.php";

    // Use prepared statements to prevent SQL injection
    $email = $_POST["email"];
    $stmt = $mysqli->prepare("SELECT id, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password and start session if login is successful
    if ($user && password_verify($_POST["password"], $user["password_hash"])) {
        session_start();
        session_regenerate_id();
        $_SESSION["user_id"] = $user["id"];
        header("Location: pm.php");
        exit;
    }

    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Game Store Login</title>
    <style>
        .video-container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        #background-video {
            object-fit: cover;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="video-container">
        <div class="content">
            <div class="container">
                <div class="login-box">
                    <h1>Welcome to Wonderscape</h1>
                    <form id="loginForm" action="login.php" method="POST">
                        <div class="form-group">
                            <input type="text" id="loginEmail" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" id="loginPassword" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit">Login</button>
                        <?php if ($is_invalid): ?>
                            <p style="color: red;">Invalid login</p>
                        <?php endif; ?>
                        <p>Don't have an account? <a href="uu.html">Sign Up</a></p>
                    </form>
                </div>
            </div>
        </div>
        <script>
    var imageUrls = ["photo/a1.jpg", "photo/a2.jpg", "photo/a3.jpg"];
    var currentImageIndex = 0;

    function changeBackground() {
        document.querySelector('.video-container').style.backgroundImage = 'url(' + imageUrls[currentImageIndex] + ')';
    }

    function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % imageUrls.length;
        changeBackground();
    }

    function prevImage() {
        currentImageIndex = (currentImageIndex - 1 + imageUrls.length) % imageUrls.length;
        changeBackground();
    }

    changeBackground();

    setInterval(nextImage,2500); 
</script>
    </div>
</body>
</html>