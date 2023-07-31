document.addEventListener("DOMContentLoaded", function () {
    const logoutLink = document.getElementById("logoutLink");
  
    if (logoutLink) {
      logoutLink.addEventListener("click", function (event) {
        event.preventDefault();
  
        // send a request to the logout PHP script
        fetch("logout.php")
          .then((response) => response.text())
          .then((data) => {
            console.log("Response from server:", data);
  
            // check if the response contains the message "Session destroyed."
            if (data.includes("Session destroyed.")) {
              // If the message is found, it means the logout was successful
              console.log("Logout successful.");
  
              // redirect to the login page after logout
              window.location.href = "login.html";
            } else {
              // If the message is not found, show an error message
              console.log("Logout failed. Please try again.");
              alert("Logout failed. Please try again.");
            }
          })
          .catch((error) => {
            // Handle any error that occurs during the AJAX-request
            console.error(error);
            alert("An error occurred. Please try again later.");
          });
      });
    }
  });
  