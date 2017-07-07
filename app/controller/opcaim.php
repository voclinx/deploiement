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
        if (isset($_POST['loginClient']) && $_POST['loginClient'] != null ||
            isset($_POST['pwdClient']) && $_POST['pwdClient'] != null ||
            isset($_POST['url_git_client']) && $_POST['url_git_hardis'] != null ||
            isset($_POST['loginHardis']) && $_POST['loginHardis'] != null ||
            isset($_POST['pwdHardis']) && $_POST['pwdHardis'] != null ||
            isset($_POST['url_git_hardis']) && $_POST['url_git_hardis'] != null
        ) {
            $db = new db();
            $db->modifyProject();
        }
        if (isset($_POST['environnement']) && isset($_POST['vers']) &&
            $_POST['environnement'] != null && $_POST['vers'] != null
        ) {
            $env = str_replace(" ","\\n",$_POST['environnement']);
            $version = str_replace(" ","_",$_POST['vers']);
            $projectId = $_SESSION['idProject'];
            exec('php ' . __DIR__ . "/deploiement.script.php " . $env . " " . $version . " " . $projectId, $output);
            $this->deployment($_GET['id']);
//            print_r($output);
        }
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
/**
 * Attention code inutile
 */
    public function Courbes()
    {
        return $this->historique();
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
        if (!count($erreur)&&isset($_SESSION['livraison'])&&$_SESSION['livraison']==true) {
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

    public function get_log_json()
    {
        $strdata = (file_exists(__dir__ . '/../data/config/log.json')) ?
            ($strdata = json_decode(file_get_contents(__dir__ . '/../data/config/log.json'), true)) : ($strdata = array());
        return $strdata;
    }

    public function get_project()
    {
        if(file_exists(__dir__ . '/../data/config/project.json')){
            $strdata = json_decode(file_get_contents(__dir__ . '/../data/config/project.json'), true) ;
        }else{
            $strdata = array();
        }
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
        $db->deleteProject();
    }

    public function modifyProject()
    {
        $db = new db();
        $db->modifyProject();
    }

    public function deployment($id){
        $db = new db();
        $db->deployment($id);
    }
}
?>
