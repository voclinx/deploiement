<?php
require_once "../../../controller/db.php";
session_start();
$db = new db();
$test = $db->getLastVersion($_POST['environnement']);

echo json_encode($test);