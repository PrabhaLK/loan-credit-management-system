<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Log the current session state before unsetting
error_log('Before unsetting, claimholder_nic: ' . (isset($_SESSION['claimholder_nic']) ? $_SESSION['claimholder_nic'] : 'not set'));

if (isset($_SESSION['claimholder_nic'])) {
    unset($_SESSION['claimholder_nic']);
    error_log('Session variable claimholder_nic has been unset.');
} else {
    // If 'claimholder_nic' is not set, log the user out
    error_log('Session variable claimholder_nic is not set, logging out.');
    include('../functions/logout_funct.php');
}

echo json_encode(['status' => 'success']);
?>