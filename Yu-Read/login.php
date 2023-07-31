<?php
// Start the session
session_start();

// check if the request is a post-request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // retrieve the username and password from the POST data
    $username = $_POST["user"];
    $password = $_POST["pass"];

    // client-side validation
    if (empty($username) || empty($password)) {
        die("Please provide both username and password.");
    }

    // Database connection
    $servername = "localhost";
    $dbusername = "kartoffel";
    $dbpassword = "islem2019"; 
    $dbname = "reg_data"; 

    // Connect to the database
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the statement to retrieve data from the users table
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // check if the user exists and if the password matches
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($password === $row["password"]) { 
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];

            // Send a success response to the client-side
            echo "success";
        } else {
            // Incorrect password, send error response
            echo "error";
        }
    } else {
        // Username not found, send error response
        echo "error";
    }

    // close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>
