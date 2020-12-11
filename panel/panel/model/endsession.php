<?php
ob_start();
session_start();
include('../controller/lcis_portal.php');
$app = new LcisPanel('localhost', 'lcis_admin', 'Liteweb@2020', 'lcis_crime');
$app->endSession();
ob_flush();
?>