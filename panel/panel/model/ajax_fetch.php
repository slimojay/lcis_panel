<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include('../controller/lcis_portal.php');
$app = new LcisPanel();
if(isset($_GET['lcis_number'])){
    $lcis_number = $app->con->real_escape_string($_GET['lcis_number']);
    echo $app->fetchInmateRecord($lcis_number);
}else{
    echo "no parameter passed";
    exit;
}

?>
