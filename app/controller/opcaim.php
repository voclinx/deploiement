<?php
require_once 'db.php';

//require_once 'push-git-recette.php';

class controller_opcaim
{

    public function create()
    {

        return json_encode($_POST);
    }

    public function modifier()
    {
        $db = new db();
        $strdata = $db->afficher_contenu_livraison('/' . $_SESSION['idProject'] . '/livraison/', $_GET['id']);
        return $strdata;
    }

    public function livraison()
    {
        if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['environnement']) && isset($_POST['vers']) &&
            $_POST['login'] != null && $_POST['password'] != null && $_POST['environnement'] != null && $_POST['vers'] != null
        ) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $env = $_POST['environnement'];
            $version = $_POST['vers'];
            exec('php ' . __DIR__ . "/deploiement.script.php ".$login." ".$password." ".$env." ".$version, $output);
            print_r($output);
        }
        //include 'deploiement.script.php';
    }

    public function supressionaction()
    {
        $db = new db();
        $file = $_GET['id'];
        $db->effacer_livraison('/' . $_SESSION['idProject'] . '/livraison/', $file);
        redirect('historiqueopcaim');

    }

    public function historique()
    {
        $files = array();
        $db = new db();
        $files = $db->afficher_livraisons('/' . $_SESSION['idProject'] . '/livraison/');
        return $files;
    }

    public function run()
    {

    }

    public function Courbes()
    {
        $data = $this->historique();
        return $data;
    }


    public function controles()
    {

        $erreur = array();
        if (empty($_POST['environnement'])) {
            $erreur[] = "le champs Environnement est requis";
        }
        if (empty($_POST['version'])) {
            $erreur[] = "le champs version est requis";
        }

        if (!$this->controle_num_version($_POST['version'])) {
            $erreur[] = 'la version doit avoir cette form 1.1.1.RC170320';
        }

        if (empty($_POST['type_livraison'])) {
            $erreur[] = "le champs type est requis";
        }


        return $erreur;
    }

    public function controle_num_version($num_version)
    {
        $pattern = '/^[0-9][0-9]*\.[0-9][0-9]*\.[0-9][0-9]*\.[A-Z][A-Z]*[0-9][0-9][0-9][0-9][0-9][0-9]$/';
        return preg_match($pattern, $num_version);
    }

    public
    function modifieraction()
    {
        $db = new db();
        $data = $_POST;

        $data = json_encode($_POST);
        $db->modifier_livraison('/' . $_SESSION['idProject'] . '/livraison/', $_POST['id'], $data);


        redirect('historiqueopcaim');

    }


    public
    function createaction()
    {
        $db = new db();
        $erreur = $this->controles();
        $data = json_encode($_POST);

        if (!count($erreur)) {

            $db->creer_livraison('/' . $_SESSION['idProject'] . '/livraison/', $_POST['environnement'], $_POST['version'], $data);
            redirect('historiqueopcaim');
        } else {
            $_SESSION["post"] = $data;
            $_SESSION['errors'] = isset($erreur) ? $erreur : null;
            $_SESSION['validation'] = 1;
            redirect('createlivraison');
        }
    }

    public
    function getLivraisonTypes()
    {

    }

    public
    function add()
    {

    }

    public
    function delete()
    {

    }

    public
    function bordereau()
    {
        $db = new db();
        $strdata = $db->afficher_contenu_livraison('/' . $_SESSION['idProject'] . '/livraison/', $_GET['id']);
        return json_decode($strdata, true);
    }

    public function get_project()
    {
        $strdata = file_get_contents(__dir__ . '/../data/project.json');
        $strdata = json_decode($strdata, true);
        return $strdata;
    }

    public function createProject()
    {
        $db = new db();
        $db->createProject();
    }

    public function deleteProject()
    {
        $db = new db();
        $db->rrmdir($_SERVER['DOCUMENT_ROOT'] . "/app/data/" . $_GET['id']);
    }

    public function modifyProject()
    {
        $db = new db();
        $db->modifyProject();
    }

}