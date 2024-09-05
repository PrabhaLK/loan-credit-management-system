<?php
if (isset($_SESSION['claimholder_nic'])) {
    unset($_SESSION['claimholder_nic']);
} else {
    // If 'claimholder_nic' is not set, log the user out
    include('../functions/logout_funct.php');
}

echo json_encode(['status' => 'success']);
