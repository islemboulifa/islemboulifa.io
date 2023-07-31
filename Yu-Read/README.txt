### Yu-Read
#### Description: A private virtual library that lets you store all of your Books titles and Mangas.
#### All the files used in the project:

#### register.html: Yu-Read registration page with a form for username and password. Users can register for a new account. Links to the login page for existing users..

#### reg.js: istens for the DOM to be ready, then adds an event listener to the registration form. When the form is submitted, it validates the password, sends a POST request to "register.php" with the username and password data, and handles the response. If registration is successful, it redirects to the login page.

#### register.php: handles the registration process. It receives the username and password from the POST data, performs client-side validation, and then connects to the MySQL database. It checks if the username already exists in the database, and if not, it inserts the new user's data into the "users" table. If the registration is successful, it stores the user ID in the session for later use and displays "Registration successful!" as feedback

#### login.html: This HTML file represents the login page for the Yu-Read website. It includes a logo, a login form with input fields for the username and password, and a "Login" button. It also provides a link to the registration page for new users to create an account.

#### login.js: The code handles login functionality. It validates form data, sends an AJAX POST request with username and password, and redirects to the main page on success or shows an error message.

#### login.php: Handles login functionality. It checks the POST data for the username and password, validates them against the database, and sends a success or error response to the client-side.

#### index.php: this PHP file serves as the homepage of Yu-Read website. It checks if the user is logged in; if not, redirects to the login page. The page displays the website logo and navigation links. It also has a description of Yu-Read and its purpose.

#### index1.php: this PHP file displays the Yu-Read virtual library for logged-in users. It fetches the user's books from the database and populates a table with book titles, authors, ratings, and status. I chose for the tables row to alternate colors for better design and readability than to keep them in one boring color.

#### index2.html: This HTML file is a webpage for the Yu-Read website. It contains a motivational message, an image, and a description of the website's origin, purpose, and the challenges faced during its creation.

#### index3.html: This HTML file is a tutorial page for the Yu-Read website. It provides step-by-step instructions on how to register, login, navigate the site, use the library editor, and manage the user's library of books and manga.

#### update.php: this php file represents the Library Editor page of the Yu-Read website. It allows users to add books to their library with title, author, rating, and status. It also enables users to permanently delete books from their library.

#### save_book.js: adds an event listener to the "saveBookForm" to handle book additions to the user's library. Upon submission, form data is sent to "save_book.php" using AJAX. The server's response determines whether a success or error message is displayed to the user.

#### save_book.php: handle the addition of books to a user's library. Upon receiving a POST request with book details, the code connects to the database, extracts the user ID from the session, and inserts the book data into the user_books table. If the insertion is successful, it sends a "success" response; otherwise, it returns an "error" response. The connection to the database is then closed.


#### delete_book.php: handles book deletion from the user's library. It checks login status, deletes the selected book record from the database, and reloads the update page. Otherwise, it redirects to the main page.

#### logout.js:  listens for the DOMContentLoaded event. When the logoutLink element is clicked, it prevents the default link behavior. Then, it sends an AJAX request to the logout.php script. If the response contains "Session destroyed," it redirects to the login page. Otherwise, it shows an error message.

#### logout.php: this php code starts a session and checks if the user is logged in. If the user is logged in, it clears all session variables, destroys the session, and then redirects to the login page. If the user is not logged in, it directly redirects to the login page without performing any further actions.

#### styles.css:  sets the styles for various elements of a website, including fonts, colors, backgrounds, and layouts. It also includes styles for navigation links, headers, forms, tables, and buttons. The code makes use of Google Fonts for the font families and defines various classes and IDs for specific elements to apply the matching styles.

#### wall2.jpg: used for the background of the website.

#### yu-read trans original logo.png: Website Logo.

#### Rest are pictures for the step by step instructions on how to use the website features.