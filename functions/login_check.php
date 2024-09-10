<?php

if (!isset($_SESSION['claimholder_nic'])) {
    $_SESSION['no_claimholder_NIC'] = '<div class="error">Please Enter NIC</div>';
    header('location: ./index.php');
} else if (!isset($_SESSION['nic'])) {
    $_SESSION['no_login_message'] = '<div class="error">Please Log-in to access Admin panel</div>';
    header('location: ../login.php');
}
?>