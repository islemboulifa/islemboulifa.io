document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
  
    loginForm.addEventListener("submit", function (event) {
      event.preventDefault();
  
      const username = document.getElementById("user").value;
      const password = document.getElementById("pass").value;
  
      // client-side validation
      if (username.trim() === "" || password.trim() === "") {
        alert("Please provide both username and password.");
        return;
      }
  
      console.log("Username:", username);
      console.log("Password:", password);
  
      // Send the login data to the server using AJAX
      fetch("login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `user=${encodeURIComponent(username)}&pass=${encodeURIComponent(password)}`,
      })
        .then((response) => response.text())
        .then((data) => {
          console.log("Response from server:", data);
          // check the response from the server
          if (data === "success") {
            // If login is successful, redirect to the main page
            window.location.href = "index.php"; 
          } else {
            // If login is unsuccessful, show an error message
            alert("Incorrect username or password. Please try again.");
          }
        })
        .catch((error) => {
          // Handle any error that occurs during the AJAX request
          console.error(error);
          alert("An error occurred. Please try again later.");
        });
    });
  });
  