<?php
// Start the session
session_start();

// check if the user is not logged in, redirect to the login page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

// retrieve the user ID from the session
$user_id = $_SESSION["user_id"];

// Database connection 
$servername = "localhost";
$dbusername = "kartoffel";  
$dbpassword = "islem2019"; 
$dbname = "reg_data"; 

// check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get the selected book title from the form
    $selected_book_title = $_POST["remove"];

    // Connect to the database
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to delete the book record
    $stmt = $conn->prepare("DELETE FROM user_books WHERE user_id = ? AND book_title = ?");
    $stmt->bind_param("is", $user_id, $selected_book_title);

    if ($stmt->execute()) {
        // Item deleted successfuly
        $stmt->close();
        $conn->close();
        header("Location: update.php"); // relaods page
        exit();
    } else {
        // Item deletion failed
        $stmt->close();
        $conn->close();
        echo "Error deleting book. Please try again.";
    }
} else {
    // If the form was not submitted, redirect back to the main page
    header("Location: index.php");
    exit();
}
?>