document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.getElementById("registerForm");

    registerForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const username = document.getElementById("username").value;
      const password = document.getElementById("password").value;
      const cpassword = document.getElementById("cpassword").value;

      // client-side validation
      if (password !== cpassword) {
        alert("Passwords do not match!");
        return;
      }

      // Send the data to the server using a POST request
      fetch("register.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`,
      })
        .then((response) => response.text())
        .then((data) => {
          // Display the response from the server
          alert(data);

          // check if the registration was successful. 
          // send to login page in case of yes 
          if (data === "Registration successful!") {
            window.location.href = "login.html"; 
          }
        })
        .catch((error) => {
          alert("Registration failed, please try again");
          console.error(error);
        });
    });
  });