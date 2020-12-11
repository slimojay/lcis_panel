<?php
include('../controller/lcis_portal.php');
$app = new LcisPanel();
if (isset($_POST['sub'])){
   echo $app->generateToken();
}

?>
