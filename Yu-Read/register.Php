<?php
// Start the session at the beginning of the file
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // retrieve the username and password from the POST data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // client-side validation
    if (empty($username) || empty($password)) {
        die("Please provide both username and password.");
    }

    // Connect to the MySQL database 
    $servername = "localhost";
    $dbusername = "kartoffel";  
    $dbpassword = "islem2019";      
    $dbname = "reg_data";  

    // Create a new connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the statement to check if the username already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if the username already exists
    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
        exit;
    }

    // prepare the statement to insert data into the users table
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

    // Counter-measure to prevent SQL injection
    $stmt->bind_param("ss", $username, $password);

    // run the statement
    if ($stmt->execute()) {
        // after successful registration, retrieve the user's ID and store it in the session for later use.
        $user_id = $conn->insert_id;
        $_SESSION['user_id'] = $user_id;
        // After successful registration send positive feedback
        echo "Registration successful!";
    } else {
        // After successful registration send negative feedback
        echo "Registration failed. Please try again later.";
    }

    // close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>
