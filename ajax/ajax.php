<?php
/**
 * Created by PhpStorm.
 * User: SBOUGH
 * Date: 15/03/2017
 * Time: 11:36
 */

require_once (__DIR__.'/../app/controller/opcaim.php');

// Valeur d'entrée
$ancienne_vers = $_POST['version'];
$evol = $_POST['evol'];
$correction = $_POST['correction'];
$bugfix = $_POST['bugfix'];

// Controle de l'ancien numero de version
$controller_opcaim = new controller_opcaim();
if (!$controller_opcaim->controle_num_version($_POST['version'])) {
    $ancienne_vers = '0.0.0.RC170101';
}

$explode = explode(".", $ancienne_vers);
$explode[0] = intval($explode[0]);
$explode[1] = intval($explode[1]);
$explode[2] = intval($explode[2]);

if ($evol == 'true') {
    $explode[1] = 0;
    $explode[2] = 0;
}

if ($correction == 'true') {
    $explode[2] = 0;
}

$id_evol = ($evol == 'true') ? $explode[0] + 1 : $explode[0];
$id_correction = ($correction == 'true') ? $explode[1] + 1 : $explode[1];
$id_bugfix = ($bugfix == 'true') ? $explode[2] + 1 : $explode[2];

echo($id_evol . '.' . $id_correction . '.' . $id_bugfix . '.' . $explode[3]);