<?php
/**
 * Created by PhpStorm.
 * User: SBOUGH
 * Date: 08/03/2017
 * Time: 16:46
 */
require 'app\controller\opcaim.php';
header('Content-Type: text/plain; charset=UTF-8;');
$controler = new controller_opcaim();
$ancienneversion = $controler->historique();
$data = array();
// important
foreach ($ancienneversion as $value) {
    if ($value != '.' && $value != "..") {
        $strdata = file_get_contents(__dir__ . '/app/data/'.$_SESSION['idProject'].'/livraison/' . $value);
        $strdata = json_decode($strdata, true);
        $data[] = $strdata;

    }

}
$data = json_encode($data);
echo($data);




