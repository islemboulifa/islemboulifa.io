document.addEventListener("DOMContentLoaded", function () {
  const saveBookForm = document.getElementById("saveBookForm");
  const messageDiv = document.getElementById("message");

  saveBookForm.addEventListener("submit", function (event) {
    event.preventDefault();

    // Get form data for adding an item
    const bookTitle = document.getElementById("book").value;
    const author = document.getElementById("author").value;
    const rating = document.getElementById("rating").value;
    const statue = document.querySelector('input[name="statue"]:checked').value;

    // prepare the data to send to the server
    const formData = new FormData();
    formData.append("book", bookTitle);
    formData.append("author", author);
    formData.append("rating", rating);
    formData.append("statue", statue);

    // send an AJAX-post request to the server-side PHP script
    fetch("save_book.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      if (data === "success") {
        // If the response is "success", display a success message
        messageDiv.innerHTML = "Book added successfully!";
        messageDiv.classList.add("success");
      } else {
        // If the response is not "success", display an error message
        messageDiv.innerHTML = "Error adding book. Please try again.";
        messageDiv.classList.add("error");
      }
    })
    .catch(error => {
      // Handle any error that occurs during the AJAX request
      messageDiv.innerHTML = "An error occurred. Please try again later.";
      messageDiv.classList.add("error");
    });
  });
});
