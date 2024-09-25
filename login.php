<?php
ini_set('session.cookie_secure', 1);  // Only send over HTTPS
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access
ini_set('session.cookie_samesite', 'Strict'); // SameSite policy

session_start();
if (isset($_SESSION['claimholder_nic']) || isset($_SESSION['nic'])) {
  $_SESSION['claimholder_nic'] = null;
  $_SESSION['nic'] = null;
  unset($_SESSION['claimholder_nic']);
  echo '<script>console.log("Session claimholder_nic is unset and set to null.");</script>';
} else {
  echo '<script>console.log("Session claimholder_nic does not exist.");</script>';
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts  -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <!--  -->
  <link rel="icon" type="image/png" href="./asset/images/icons/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="./asset/vendor/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="./asset/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="./asset/fonts/iconic/css/material-design-iconic-font.min.css" />
  <link rel="stylesheet" type="text/css" href="./asset/vendor/animate/animate.css" />
  <link rel="stylesheet" type="text/css" href="./asset/vendor/css-hamburgers/hamburgers.min.css" />
  <link rel="stylesheet" type="text/css" href="./asset/vendor/animsition/css/animsition.min.css" />
  <link rel="stylesheet" type="text/css" href="./asset/vendor/select2/select2.min.css" />
  <link rel="stylesheet" type="text/css" href="./asset/vendor/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="./asset/css/login/util.css" />
  <link rel="stylesheet" type="text/css" href="./asset/css/login/main.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .txt-login {
      font-family: poppins;
      font-weight: bold;
    }
  </style>
</head>
<?php include('./functions/validate-login.php'); ?>

<body>
  <Script>
    function getCookie(name) {
      let cookieArr = document.cookie.split(";"); // Get all cookies as a string array

      // Loop through the array
      for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("="); // Split name and value

        // Remove leading whitespace and compare cookie name
        if (name === cookiePair[0].trim()) {
          return decodeURIComponent(cookiePair[1]); // Return cookie value
        }
      }

      // Return null if the cookie wasn't found
      return null;
    }
    // Example: Read a specific cookie
    let sessionId = getCookie("PHPSESSID");
    console.log("PHPSESSID:", sessionId);

    function deleteCookie(name) {
      document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }

    // Example: Delete the PHPSESSID cookie
    deleteCookie("PHPSESSID");
  </Script>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form class="login100-form validate-form" method="POST" action="./functions/login_funct.php">
          <span class="login100-form-title p-b-26 txt-login"> Login </span>
          <span class="login100-form-title p-b-48">
            <i class="zmdi zmdi-font"></i>
          </span>

          <?php
          // PHP code to display error message if login fails
          if (isset($_SESSION['login_error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
            unset($_SESSION['login_error']);
          }
          ?>

          <div class="wrap-input100 validate-input" data-validate="Valid NIC is required">
            <input class="input100" type="text" name="nic" />
            <span class="focus-input100" data-placeholder="National ID Number"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Enter password">
            <span class="btn-show-pass">
              <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" name="pass" />
            <span class="focus-input100" data-placeholder="Password"></span>
          </div>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button type="submit" class="login100-form-btn txt-login">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="dropDownSelect1"></div>

  <script src="./asset/vendor/jquery/jquery-3.2.1.min.js"></script>
  <script src="./asset/vendor/animsition/js/animsition.min.js"></script>
  <script src="./asset/vendor/bootstrap/js/popper.js"></script>
  <script src="./asset/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="./asset/vendor/select2/select2.min.js"></script>
  <script src="./asset/vendor/daterangepicker/moment.min.js"></script>
  <script src="./asset/vendor/daterangepicker/daterangepicker.js"></script>
  <script src="./asset/vendor/countdowntime/countdowntime.js"></script>
  <script src="./asset/js/login.js"></script>
</body>

</html>