<?php
include('../config/headers.php');

function redirectWithError($sessionKey, $message, $location)
{
    $_SESSION[$sessionKey] = $message; // Store the error message in the session
    header('Location: ' . $location);
    exit(); // Stop further execution after redirect
}

// Checking if the user is logged in
if (!isset($_SESSION['nic'])) {
    $_SESSION['NIC-Status'] = 'Please log in to access Admin panel'; // Set message for toast
    redirectWithError('no_login_message', $_SESSION['NIC-Status'], '../login.php');
}

// Additional check for 'govt-hos.php' or pages that require NIC and login
if (basename($_SERVER['PHP_SELF']) === 'govt-hos.php') {
    if (!isset($_SESSION['claimholder_nic'])) {
        $_SESSION['claimholder-NIC-Status'] = 'Please enter NIC'; // Set message for toast
        redirectWithError('no_claimholder_NIC', $_SESSION['claimholder-NIC-Status'], './index.php');
    }
}

if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 900) { // Session Expire After 15 Mins
    session_unset();
    session_destroy();
    exit();
}