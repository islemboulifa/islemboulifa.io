
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="styles.css" rel="stylesheet">
    <script src="save_book.js"></script>
    <script src="logout.js"></script>
    <title>Library Editor</title>

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
    <p class="lib">Library Editor</p>
</div>
<div class="edit">
    <h2>Add to your Library </h2>
    <form id="saveBookForm" action="save_book.php" method="post">
        <div>
            <label for="book">Book Title: </label>
            <input class="book" type="text" id="book" name="book" required>
        </div>
        <br>
        <div>
            <label for="author">Book's Author: </label>
            <input class="book" type="text" id="author" name="author">
        </div>
        <br>
        <div>
            <label for="rating">Select Rating:</label>
            <select id="rating" name="rating">
                <option value="5">5 stars</option>
                <option value="4">4 stars</option>
                <option value="3">3 stars</option>
                <option value="2">2 stars</option>
                <option value="1">1 star</option>
            </select>
        </div>
        <br>
        <div>
            <label>State: </label>
            <label class="statue" for="wishlist">Wishlist</label>
            <input type="radio" id="wishlist" name="statue" value="Wishlist" required>
            <label class="statue" for="reading">Reading</label>
            <input type="radio" id="reading" name="statue" value="Reading" required>
            <label class="statue" for="finished">Finished</label>
            <input type="radio" id="finished" name="statue" value="Finished" required>
        </div>
        <br>
        <button class="register" type="submit">Confirm</button>
        <br>
    </form>
    <div id="message"></div>
</div>

<div class="edit">
    <h2>Permanently delete from Library</h2>
    <form id="deleteBookForm" action="delete_book.php" method="post">
        <div>
            <label for="remove">Book Title:</label>
            <select class="remove" id="remove" name="remove">
                <option disabled selected>Select a Book</option>
                <?php
                    // start the session
                    session_start();

                    // check if the user is not logged in, redirect to the login page
                    if (!isset($_SESSION["user_id"])) {
                        header("Location: login.html");
                        exit();
                    }

                    // retrieve the user ID from the session
                    $user_id = $_SESSION["user_id"];

                    // database connection
                    $servername = "localhost";
                    $dbusername = "kartoffel";
                    $dbpassword = "islem2019";
                    $dbname = "reg_data";

                    // connect to the database
                    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                    // checks connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // retrieve the user's books from the user_books table
                    $stmt = $conn->prepare("SELECT book_title FROM user_books WHERE user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // loop through the result and display the books
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row["book_title"]) . '">' . htmlspecialchars($row["book_title"]) . '</option>';
                    }
                    // closes the statement and the database connection
                    $stmt->close();
                    $conn->close();
                ?>
            </select>
        </div>
        <button class="register" type="submit">Delete</button>
    </form>
</div>
</body>
</html>