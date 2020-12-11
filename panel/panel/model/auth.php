<?php
ob_start();
session_start();
include('../controller/lcis_portal.php');
$app = new LcisPanel();
$input = $_POST['input'];
$app->crossToken($input);
ob_flush();
?>
