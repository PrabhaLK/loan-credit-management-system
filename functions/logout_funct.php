<?php
session_start();
$_SESSION['nic']=null;
$_SESSION['claimholder_nic']=null;
session_unset();
session_destroy();
setcookie(session_name(), '', time() - 3, '/');
header("Location: ../login.php");
?>