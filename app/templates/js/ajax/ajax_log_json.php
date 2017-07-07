<?php
/**
 * Created by PhpStorm.
 * User: SBOUGH
 * Date: 25/04/2017
 * Time: 17:10
 */
require (__DIR__.'/../../../controller/opcaim.php');
header('Content-Type: text/plain; charset=UTF-8;');
$controler = new controller_opcaim();
$data = $controler->get_log_json();
$data_project = $controler->get_project();



$data = json_encode(array_merge($data, $data_project));
echo($data);
