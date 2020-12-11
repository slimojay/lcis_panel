<?php
include('../controller/lcis_portal.php');
$app = new LcisPanel('localhost', 'lcis_admin', 'Liteweb@2020', 'lcis_crime');
if (isset($_GET['lcis_number'])){
    $lcis_number = $_GET['lcis_number'];
    echo $app->deleteUser($lcis_number);   
}else{
    echo "no parameter passed";
    exit;
}
?>
