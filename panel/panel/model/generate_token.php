<?php
include('../controller/lcis_portal.php');
$app = new LcisPanel('localhost', 'lcis_admin', 'Liteweb@2020', 'lcis_crime');
if (isset($_POST['sub'])){
   echo $app->generateToken();
}

?>