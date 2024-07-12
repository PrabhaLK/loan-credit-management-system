<?php
include('../config/db.php');
// print_r($_POST);
foreach ($_POST['product_name'] as $key => $value) {
    $sql = 'insert into user-claim-bills (Dates, RoomCharges, MTest, SMTratment) VALUES(Dates,)';
}
