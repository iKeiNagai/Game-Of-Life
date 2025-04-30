document.addEventListener("DOMContentLoaded", function () {
  const signupForm = document.getElementById("signupForm");
  const loginForm = document.getElementById("loginForm");

  // Handle signup
  if (signupForm) {
      signupForm.addEventListener("submit", function (e) {
          e.preventDefault();

          const username = document.getElementById("signupUsername").value;
          const email = document.getElementById("signupEmail").value;
          const password = document.getElementById("signupPassword").value;

          fetch("signup.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
              },
              body: new URLSearchParams({
                  username,
                  email,
                  password,
              }),
          })
              .then((response) => response.json())
              .then((data) => {
                  if (data.status === "success") {
                      window.location.href = "login.html"; // Redirect to login
                  } else {
                      alert(data.message); // Show error message
                  }
              });
      });
  }

  // Handle login form submission
  if (loginForm) {
      loginForm.addEventListener("submit", function (e) {
          e.preventDefault();

          const username = document.getElementById("loginUsername").value;
          const password = document.getElementById("loginPassword").value;

          fetch("login.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
              },
              body: new URLSearchParams({
                  username,
                  password,
              }),
          })
              .then((response) => response.json())
              .then((data) => {
                  if (data.status === "success") {
                      window.location.href = "game.html"; // Redirect to the game page
                  } else {
                      alert(data.message); // Show error message
                  }
              });
      });
  }
});
