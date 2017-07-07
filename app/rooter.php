<?php

class rooter
{

    public function __construct($action)
    {
        if (method_exists($this, $action)) {
            call_user_func(array($this, $action));
        } else {
            $this->accueil();
        }
    }

    public function modifierLivraison()
    {
        $controler = new controller_opcaim();
        $_SESSION["validation"] = 1;
        $_SESSION["post"] = $controler->modifier();
        $db = new db();
        $branch = $db->getGitBranch("\"D:/workspace/srv_deploiement/srv_hardis/OPCAIM\"");
        include "templates/create.php";
    }

    public function createlivraison()
    {
        $controler = new controller_opcaim();
        $data = $controler->create();
        $ancienneversion = $controler->historique();
        $db = new db();
        $branch = $db->getGitBranch("\"D:/workspace/srv_deploiement/srv_hardis/OPCAIM\"");
        //$erreur = $controler ->controles();
        include "templates/create.php";
    }


    public function historiqueopcaim()
    {
        $controler = new controller_opcaim();
        $data = $controler->historique();

        $db = new db();
        $branchHardis = $db->getGitBranch($_SERVER['DOCUMENT_ROOT'].'\..\srv_deploiement\srv_hardis\OPCAIM');
        $branchClient = $db->getGitBranch($_SERVER['DOCUMENT_ROOT'].'\..\srv_deploiement\srv_client\OPCAIM');
        include "templates/historique.php";
    }

    public function createaction()
    {
        $controler = new controller_opcaim();
        $data = $controler->createaction();
        //include "templates/historique.php";
    }

    public function modifieraction()
    {
        $controler = new controller_opcaim();
        $data = $controler->modifieraction();
        include "templates/historique.php";
    }

    public function livraison()
    {
        $controler = new controller_opcaim();
        $data = $controler->livraison();
        //include "templates/livraison.php";
    }

    public function supression()
    {
        $controler = new controller_opcaim();
        $data = $controler->supressionaction();
        include "templates/supression.php";

    }

    public function bordereau()
    {
        $controler = new controller_opcaim();
        $data = $controler->bordereau();
        include "templates/bordereau.php";
    }

    public function index()
    {
        if (isset($_GET['idProject']) && $_GET['idProject'] != null
            && isset($_GET['nameProject']) && $_GET['nameProject'] != null
        ) {
            $_SESSION['idProject'] = $_GET['idProject'];
            $_SESSION['nameProject'] = $_GET['nameProject'];
        }

        $controller = new controller_opcaim();
        $data = $controller->courbes();
        include "templates/index.php";
    }

    public function accueil()
    {
        $controller = new controller_opcaim();
        $data = $controller->get_project();

        include "templates/accueil.php";
    }

    public function createProject()
    {
        $controller = new controller_opcaim();
        $controller->createProject();
        redirect(accueil);
    }

    public function deleteProject()
    {
        $controller = new controller_opcaim();
        $controller->deleteProject();
        redirect(accueil);
    }

    public function modifyProject()
    {
        $controller = new controller_opcaim();
        $controller->modifyProject();
        redirect(accueil);
    }
}


function redirect($action, $data = array())
{
    // if (method_exists(new rooter(),$action)){
    header("Location : index.php?action=$action");
    // }
}