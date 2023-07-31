<?php
// Start the session
session_start();

// check if the user is not logged in, redirect to the login page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

// store the user ID from the session
$user_id = $_SESSION["user_id"];

// Database connection
$servername = "localhost";
$dbusername = "kartoffel";  
$dbpassword = "islem2019";  
$dbname = "reg_data";      

// connect to the database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare the statement to retrieve the user's books from the user_books table
$stmt = $conn->prepare("SELECT book_title, author, rating, status FROM user_books WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// close the statement and the database connection
$stmt->close();
$conn->close();
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
    <style>
        table td {
        padding-left: 10px;
        padding-bottom: 5px;
        padding-top: 5px
        }

        .row-odd {
        background-color: rgba(192, 162, 212, 0.349);
        }

        .row-even {
        background-color: rgba(75, 59, 100, 0.507);
        color: #d0a5db;
        }
    </style>
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
<div>
    <p class="lib">Here lies your virtual Yu-Read library</h2>
</div>
<div class="alter">
    <p>For updating your library click here <a href="update.php">📖</a></p>
</div>
<div class="books">
    <table class="books_table">
        <thead>
            <tr>
                <th class="book">Book</th>
                <th>Author</th>
                <th>Rating</th>
                <th>State</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // loop through the result and generate table rows with book data
                $row_color = "even"; // attribute the row color as even
                while ($row = $result->fetch_assoc()) {
                    // alternates the row color for each row
                    // and apply different CSS classes for odd and even rows
                    $row_color = ($row_color == "even") ? "odd" : "even";
                    $row_class = "row-" . $row_color;
                    
                    echo '<tr class="' . $row_class . '">';
                    echo '<td scope="row">' . htmlspecialchars($row["book_title"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["author"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["rating"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["status"]) . '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
