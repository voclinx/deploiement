<?php
/**
 * Created by PhpStorm.
 * User: SBOUGH
 * Date: 08/03/2017
 * Time: 16:46
 */
require __DIR__ . '/app/controller/opcaim.php';
header('Content-Type: text/plain; charset=UTF-8;');
session_start();

$controler = new controller_opcaim();
$ancienneversion = $controler->historique();
$data = array();
// important
foreach ($ancienneversion as $value) {
    if ($value != '.' && $value != "..") {
        $strdata = file_get_contents(__dir__ . '/app/data/project/' . $_SESSION['idProject'] . '/livraison/' . $value);
        $strdata = json_decode($strdata, true);
        $data[] = $strdata;
    }
}

$data = json_encode($data);
echo($data);




