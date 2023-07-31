<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="styles.css" rel="stylesheet">
    <script src="logout.js"></script>
    <title>Yu Read</title>
</head>
<body>
<header>
    <a href="index.php"><img class="logo" src="yu-read trans original logo.png" alt="logo"></a>
    <nav class="nav">
        <ul class="nav_links">
            <li><a href="index1.php">Yu-Books</a></li>
            <li><a href="index2.html">Motive</a></li>
            <li><a href="index3.html">Help</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

</header>
<div class="description">
    <h1>Yu-read</h1>
    <p>Don't have the money to build a private library?</p>
    <p>We got you Homie</p>
</div>
</body>
</html>