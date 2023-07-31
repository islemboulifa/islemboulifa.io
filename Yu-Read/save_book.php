<?php
// Start the session
session_start();

// Check if the user is logged in (user ID is set in the session)
if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.html");
    exit();
}

// database connection
$servername = "localhost";
$dbusername = "kartoffel";  
$dbpassword = "islem2019";  
$dbname = "reg_data";       

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // store the book details from the form submission
    $bookTitle = $_POST["book"];
    $author = $_POST["author"];
    $rating = $_POST["rating"];
    $status = $_POST["statue"];

    // Handles form submission for adding a book
    if (isset($bookTitle, $status)) {
        // prepare the SQL query to insert the item into the user_books table
        $stmt = $conn->prepare("INSERT INTO user_books (user_id, book_title, author, rating, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $userId, $bookTitle, $author, $rating, $status);

        
        if ($stmt->execute()) {
            // send a success response if it's successful 
            echo "success";
        } else {
            // send an error response it wasn't successful 
            echo "error";
        }
        
        // close the statement
        $stmt->close();
    } else {
        // send an error response to the client-side
        echo "error";
    }
}

// Close the database connection
$conn->close();
?>
