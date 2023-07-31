<?php
// Start the session
session_start();

// check if the user is logged in, then proceed with logout
if (isset($_SESSION["user_id"])) {
    // clear all session variables
    $_SESSION = array();

    // destroy the session
    session_destroy();

    header("Location: login.html");
    exit();
} else {
    header("Location: login.html");
    exit();
}
?>
