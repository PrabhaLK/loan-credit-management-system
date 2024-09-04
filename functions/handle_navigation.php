<?php
session_start();
unset($_SESSION['claimholder_nic']);
echo json_encode(['status' => 'success']);
?>