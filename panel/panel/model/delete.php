<?php
include('../controller/lcis_portal.php');
$app = new LcisPanel();
if (isset($_GET['lcis_number'])){
    $lcis_number = $_GET['lcis_number'];
    echo $app->deleteUser($lcis_number);   
}else{
    echo "no parameter passed";
    exit;
}
?>
