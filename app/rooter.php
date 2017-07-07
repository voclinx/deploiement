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
        $branch = $db->getGitBranch($_SESSION['idProject']);
        include "templates/create.php";
    }

    public function createlivraison()
    {
        $controler = new controller_opcaim();
        $data = $controler->create();
        $ancienneversion = $controler->historique();
        $db = new db();
        $branch = $db->getGitBranch($_SESSION['idProject']);
        //$erreur = $controler ->controles();
        include "templates/create.php";
    }


    public function historiqueopcaim()
    {
        $controler = new controller_opcaim();
        $data = $controler->historique();

        $db = new db();
        $branches = $db->getGitBranch($_SESSION['idProject']);
        include "templates/historique.php";
    }

    public function createaction()
    {
        $controler = new controller_opcaim();
        $controler->createaction();
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
        redirect('historiqueopcaim');
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
        redirect('accueil');
    }

    public function deleteProject()
    {
        $controller = new controller_opcaim();
        $controller->deleteProject();
        redirect('accueil');
    }

    public function modifyProject()
    {
        $controller = new controller_opcaim();
        $controller->modifyProject();
	if(isset($_POST["redirect"])&&$_POST["redirect"]==true){
		redirect('historiqueopcaim');
	}else{        	
		redirect('accueil');
	}
    }
}


function redirect($action, $data = array())
{
    if($action=='accueil'){
        header('Location: index.php');
    }else{
        header('Location: index.php?action='.$action);
    }
}
?>
