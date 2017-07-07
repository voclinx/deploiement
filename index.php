<?php
date_default_timezone_set('Europe/Paris');
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "boostrap.php";
require_once "app/controller/opcaim.php";
require_once "app/rooter.php";
require_once "app/controller/db.php";
new controller_opcaim();

if (isset($_GET['action']) && ($_GET['action'] == 'createaction'
        || $_GET['action'] == 'modifieraction'
        || $_GET['action'] == 'supression'
        || $_GET['action'] == 'createProject'
        || $_GET['action'] == 'deleteProject'
        || $_GET['action'] == 'modifyProject'
        || $_GET['action'] == 'livraison'
    )
) {
    new rooter(@$_GET['action']);
}else{
    include __DIR__."/app/templates/header.php";
    new rooter(@$_GET['action']);
    include __DIR__."/app/templates/footer.php";
}

?>
