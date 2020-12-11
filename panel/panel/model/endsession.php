<?php
ob_start();
session_start();
include('../controller/lcis_portal.php');
$app = new LcisPanel();
$app->endSession();
ob_flush();
?>
