<?php

/**
 * Created by PhpStorm.
 * User: SBOUGH
 * Date: 04/04/2017
 * Time: 18:15
 */
class db
{
    public function afficher_contenu_livraison($location, $file)
    {
        if (file_exists(__dir__ . '/../data/project/' . $location . $file)) {
            $strdata = file_get_contents(__dir__ . '/../data/project/' . $location . $file);
            return $strdata;
        } else {
            return 'db:15 fichier inexistant';
        }
    }

    public function effacer_livraison($location, $file)
    {
        if (file_exists(__dir__ . '/../data/project/' . $location . $file)) {
            return unlink(__dir__ . '/../data/project/' . $location . $file);
        }
    }

    public function afficher_livraisons($location)
    {
        return $files = scandir(__dir__ . '/../data/project/' . $location);
    }

    public function modifier_livraison($location, $id, $data)
    {
        return file_put_contents(__dir__ . '/../data/project/' . $location . $id, $data);

    }

    public function creer_livraison($location, $environnement, $version, $data)
    {
        if (isset($location) && $location != null && isset($environnement) && $environnement != null && isset($version) && $version != null && isset($data) && $data != null)
            return file_put_contents(__dir__ . '/../data/project/' . $location . time() . '-' . $environnement . '-' . $version . '-' . date('YmdHi') . '-' . 'txt', $data);
    }

    public function createProject()
    {
        if (isset($_POST['projectName']) && $_POST['projectName'] != null) {
            //Vérifie si l'URL du dépot Client a été saisie
            if (isset($_POST['url_git_client']) && $_POST['url_git_client'] != null) {
                $url_Git_Client = strstr($_POST['url_git_client'], '@');
                if($url_Git_Client==false){
                    $url_Git_Client = '@'.strstr($url_Git_Client, '://',true);
                }
                //Vérifie si le login et le password du dépot Client ont été saisie
                if (isset($_POST['loginClient']) && $_POST['loginClient'] != null
                    && isset($_POST['pwdClient']) && $_POST['pwdClient'] != null
                ) {
                    $log_git_client = $_POST['loginClient'];
                    $pwd_git_client = $_POST['pwdClient'];
                } else {
                    $log_git_client = null;
                    $pwd_git_client = null;
                }
            } else {
                $url_Git_Client = null;
                $log_git_client = null;
                $pwd_git_client = null;
            }
            //Vérifie si l'URL du dépot Hardis a été saisie
            if (isset($_POST['url_git_hardis']) && $_POST['url_git_hardis'] != null) {
                $url_Git_Hardis = strstr($_POST['url_git_hardis'], '@');
                if($url_Git_Hardis==false){
                    $url_Git_Hardis = '@'.strstr($url_Git_Hardis, '://',true);
                }
                //Vérifie si le login et le password du dépot Hardis ont été saisie
                if (isset($_POST['loginHardis']) && $_POST['loginHardis'] != null
                    && isset($_POST['pwdHardis']) && $_POST['pwdHardis'] != null
                ) {
                    $log_git_hardis = $_POST['loginHardis'];
                    $pwd_git_hardis = $_POST['pwdHardis'];
                } else {
                    $log_git_hardis = null;
                    $pwd_git_hardis = null;
                }
            } else {
                $url_Git_Hardis = null;
                $log_git_hardis = null;
                $pwd_git_hardis = null;
            }
            //chargement des fichier project.json et log.json et convertie en variable php
            $strLog = file_get_contents(__dir__ . '/../data/config/log.json');
            $log_json_data = json_decode($strLog, true);
            $strdata = file_get_contents(__dir__ . '/../data/config/project.json');
            $json_data = json_decode($strdata, true);

            //Recherche de l'id le plus haut
            if (end($json_data) != false) {
                $idProject = end($json_data)['projectId'] += 1;
            } else {
                $idProject = 0;
            }

            //création de la variable PHP contenant le nouveau projet
            $projet_json = array('projectId' => $idProject, 'projectName' => $_POST['projectName'], 'url_git_hardis' => $url_Git_Hardis, 'url_git_client' => $url_Git_Client);
            $log_json = array('projectId' => $idProject, 'loginClient' => $log_git_client, 'pwdClient' => $pwd_git_client, 'loginHardis' => $log_git_hardis, 'pwdHardis' => $pwd_git_hardis);
            //remplace le contenu du fichier
            //Cas ou le fichier n'est pas créer ou qu'il est vide
            if (!$strLog || strlen($strLog) == 0) {
                $log_json_data = array($log_json);
            } else {
                //concaténation de la variable PHP contenant le nouveau projet et des anciens projets
                array_push($log_json_data, $log_json);
            }

            //remplace le contenu du fichier
            //Cas ou le fichier n'est pas créer ou qu'il est vide
            if (!$strdata || strlen($strdata) == 0) {
                $json_data = array($projet_json);
            } else {
                //concaténation de la variable PHP contenant le nouveau projet et des anciens projets
                array_push($json_data, $projet_json);
            }

            file_put_contents(__dir__ . '/../data/config/log.json', json_encode($log_json_data));
            file_put_contents(__dir__ . '/../data/config/project.json', json_encode($json_data));

            //Création de l'arborescence de donnée du projet
            mkdir(__dir__ . '/../data/project/' . $projet_json['projectId'], 0700, true);
            mkdir(__dir__ . '/../data/project/' . $projet_json['projectId'] . '/livraison', 0700, true);
            mkdir(__dir__ . '/../data/project/' . $projet_json['projectId'] . '/img', 0700, true);
            //Upload de le logo dans le fichier image du projet
            $tmp_name = $_FILES["logo"]["tmp_name"];
            move_uploaded_file($tmp_name, __dir__ . '/../data/project/' . $projet_json['projectId'] . '/img/logo.png');
        }
    }

    public function deleteProject()
    {
        //chargement du fichier project.json et convertie en variable php
        $strdata = file_get_contents(__dir__ . '/../data/config/project.json');
        $json_data = json_decode($strdata, true);

        for ($i = 0; $i < count($json_data); $i++) {
            //supprime le projet dans le json ou l'id est recu en GET
            if ($json_data[$i]["projectId"] == $_GET['id']) {
                unset($json_data[$i]);
                $json_data = array_merge(array(), $json_data);
                file_put_contents(__dir__ . '/../data/config/project.json', json_encode($json_data));
            }
        }
        //chargement du fichier log.json et convertie en variable php
        $strlog = file_get_contents(__dir__ . '/../data/config/log.json');
        $log_json_data = json_decode($strlog, true);

        for ($i = 0; $i < count($log_json_data); $i++) {
            //supprime le projet dans le json ou l'id est recu en GET
            if ($log_json_data[$i]["projectId"] == $_GET['id']) {
                unset($log_json_data[$i]);
                $log_json_data = array_merge(array(), $log_json_data);
                file_put_contents(__dir__ . '/../data/config/log.json', json_encode($log_json_data));
            }
        }
        //Supprime les données liée au site du projet (img, livraison ...)
        $this->rrmdir($_SERVER['DOCUMENT_ROOT'] . "/app/data/project/" . $_GET['id']);
        //Supprime les données liée au site du projet (img, livraison ...)
        $this->rrmdir($_SERVER['DOCUMENT_ROOT'] . "/../srv_deploiement/srv_client/" . $_GET['id']);
        //Supprime les données liée au site du projet (img, livraison ...)
        $this->rrmdir($_SERVER['DOCUMENT_ROOT'] . "/../srv_deploiement/srv_hardis/" . $_GET['id']);
    }

    private function rrmdir($dir)
    {
        if (file_exists($dir)) {
            if (is_dir($dir)) {
                $files = scandir($dir);
                foreach ($files as $elem) {
                    if ($elem != "." && $elem != "..") {
                        $this->rrmdir($dir . '/' . $elem);
                    }
                }
                return rmdir($dir);
            } else {
                $res = unlink($dir);
            }
        }
    }

    public function modifyProject()
    {
        if (isset($_GET['id']) && $_GET['id'] != null) {
            $idProject = $_GET['id'];
        } else {
            $idProject = $_SESSION['idProject'];
        }
        /*
         * Changement des données dans project.json
         */
        //chargement du fichier project.json et convertie en variable php
        $strdata = file_get_contents(__dir__ . '/../data/config/project.json');
        $json_data = json_decode($strdata, true);
        for ($i = 0; $i < count($json_data); $i++) {
            if ($json_data[$i]['projectId'] == $idProject) {
                //Changement du nom de projet si il est saisi
                if (isset($_POST['projectName']) && $_POST['projectName'] != null) {
                    $json_data[$i]['projectName'] = $_POST['projectName'];
                }
                //Changement du depot git hardis si il est saisi
                if (isset($_POST['url_git_hardis']) && $_POST['url_git_hardis'] != null) {
                    $json_data[$i]['url_git_hardis'] = strstr($_POST['url_git_hardis'], '@');
                    if($json_data[$i]['url_git_hardis']==false){
                        $json_data[$i]['url_git_hardis'] = '@'.strstr($_POST['url_git_hardis'], '://',true);
                    }
                }
                //Changement du depot git client du projet si il est saisi
                if (isset($_POST['url_git_client']) && $_POST['url_git_client'] != null) {
                    $json_data[$i]['url_git_client'] = strstr($_POST['url_git_client'], '@');
                    if($json_data[$i]['url_git_client']==false){
                        $json_data[$i]['url_git_client'] = '@'.strstr($_POST['url_git_client'], '://',true);
                    }
                }
                //Changement de l'image de projet si il est saisi
                if (isset($_FILES['logo']) && $_FILES['logo'] != null) {
                    //remplace le logo dans le fichier json
                    $json_data[$i]['fileNameLogo'] = $_FILES['logo']['name'];
                    //Upload le logo dans le dossier img du projet (Remplace l'ancienne)
                    $tmp_name = $_FILES["logo"]["tmp_name"];
                    $test = move_uploaded_file($tmp_name, __dir__ . '/../data/project/' . $_GET['id'] . '/img/logo.png');
                }
                file_put_contents(__dir__ . '/../data/config/project.json', json_encode($json_data));
            }
        }
        /*
         * Changement des données dans log.json
         */
        $strlog = file_get_contents(__dir__ . '/../data/config/log.json');
        $log_json_data = json_decode($strlog, true);
        for ($i = 0; $i < count($log_json_data); $i++) {
            if ($log_json_data[$i]['projectId'] == $idProject) {
                //Changement du nom de projet si il est saisi
                if (isset($_POST['loginClient']) && $_POST['loginClient'] != null) {
                    $log_json_data[$i]['loginClient'] = $_POST['loginClient'];
                }
                //Changement du depot git hardis si il est saisi
                if (isset($_POST['pwdClient']) && $_POST['pwdClient'] != null) {
                    $log_json_data[$i]['pwdClient'] = $_POST['pwdClient'];
                }
                //Changement du depot git client du projet si il est saisi
                if (isset($_POST['loginHardis']) && $_POST['loginHardis'] != null) {
                    $log_json_data[$i]['loginHardis'] = $_POST['loginHardis'];
                }
                //Changement du depot git client du projet si il est saisi
                if (isset($_POST['pwdHardis']) && $_POST['pwdHardis'] != null) {
                    $log_json_data[$i]['pwdHardis'] = $_POST['pwdHardis'];
                }
                file_put_contents(__dir__ . '/../data/config/log.json', json_encode($log_json_data));
            }
        }
    }

    public function getGitBranch($projectId)
    {
        include __DIR__ . "/../config/environnement_path.php";
        $url = $this->getUrlGit($projectId);
        $log = $this->getLog($projectId);
        // ls-remote --heads http://ycourard@pid.hardis.fr//r/OPCAIM.
        $cmd = GIT . " ls-remote --heads http://" . $log['loginHardis'] . ":" . $log['pwdHardis'] . $url['hardis'];
        exec($cmd, $output1);
        $cmd = GIT . " ls-remote --heads http://" . $log['loginClient'] . ":" . $log['pwdClient'] . $url['client'];
        exec($cmd, $output2);
        $branches = array("hardis" => $output1, "client" => $output2);

        return $branches;
    }

    public function getLog($projectId)
    {
        $strlog = file_get_contents(__dir__ . '/../data/config/log.json');
        $log_json_data = json_decode($strlog, true);

        foreach ($log_json_data as $key => $value) {
            if ($log_json_data[$key]['projectId'] == $projectId) {
                return array('projectId' => $log_json_data[$key]['projectId'],
                    'loginClient' => $log_json_data[$key]['loginClient'],
                    'pwdClient' => $log_json_data[$key]['pwdClient'],
                    'loginHardis' => $log_json_data[$key]['loginHardis'],
                    'pwdHardis' => $log_json_data[$key]['pwdHardis']);
            }
        }
        return false;
    }

    public function getUrlGit($projectId)
    {
        $strdata = file_get_contents(__dir__ . '/../data/config/project.json');
        $json_data = json_decode($strdata, true);

        foreach ($json_data as $key => $value) {
            if ($json_data[$key]['projectId'] == $projectId) {
                return array('hardis' => $json_data[$key]['url_git_hardis'],
                    'client' => $json_data[$key]['url_git_client'],
                );
            }
        }
        return false;
    }

    /*
     * $depot == HARDIS OR $depot == CLIENT
     * false manque rien
     * true manque quelque chose
     */
    public function checkDataDeploye($projectId, $depot)
    {
        $log = $this->getLog($projectId);
        $git = $this->getUrlGit($projectId);
        if ($git !== false && $log !== false) {
            foreach ($git as $key => $value) {
                if (strstr($key, $depot) == strtoupper($depot) && (!isset($value) || $value == null)) {
                    return true;
                }
            }

            foreach ($log as $key => $value) {
//                print 'strtoupper($key) : '.strtoupper($key).'<br/>';
//                print 'strtoupper($depot) : '.strtoupper($depot).'<br/>';
//                print 'strstr(strtoupper($key), strtoupper($depot)) : '.strstr(strtoupper($key), strtoupper($depot)).'<br/>';

                if (strstr(strtoupper($key), strtoupper($depot)) == strtoupper($depot) && (!isset($value) || $value == null)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function setUrlGit($fullUrl)
    {
        $url = strstr($fullUrl, '@');
        return $url;
    }

    public function deployment($id){
        $strdata = file_get_contents(__dir__ . '/../data/project/'.$_SESSION['idProject'].'/livraison/'.$id);
        $json_data = json_decode($strdata, true);
        $json_data['deploiement'] = true;
        file_put_contents(__dir__ . '/../data/project/'.$_SESSION['idProject'].'/livraison/'.$id, json_encode($json_data));
    }

    public function getDeployment($id){
        $strdata = file_get_contents(__dir__ . '/../data/project/'.$_SESSION['idProject'].'/livraison/'.$id);
        $json_data = json_decode($strdata, true);
        if(isset($json_data['deploiement'])&&$json_data['deploiement']==true){
            return true;
        }else{
            return false;
        }
    }
}



