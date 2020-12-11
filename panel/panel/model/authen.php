<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
include('../controller/lcis_portal.php');
$app = new LcisPanel('localhost', 'lcis_admin', 'Liteweb@2020', 'lcis_crime');
$app->checkIsAuth();
?>