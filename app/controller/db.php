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

        $strdata = file_get_contents(__dir__ . '/../data/' . $location . $file);
        return $strdata;
    }

    public function effacer_livraison($location, $file)
    {
        return unlink(__dir__ . '/../data/' . $location . $file);

    }

    public function afficher_livraisons($location)
    {
        return $files = scandir(__dir__ . '/../data/' . $location);
    }

    public function modifier_livraison($location, $id, $data)
    {
        return file_put_contents(__dir__ . '/../data/' . $location . $id, $data);

    }

    public function creer_livraison($location, $environnement, $version, $data)
    {
        return file_put_contents(__dir__ . '/../data/' . $location . time() . '-' . $environnement . '-' . $version . '-' . date('YmdHi') . '-' . 'txt', $data);


    }

    public function createProject()
    {

        if (isset($_POST['projectName']) && $_POST['projectName'] != null
            && isset($_POST['url_git_client']) && $_POST['url_git_client'] != null
            && isset($_POST['url_git_hardis']) && $_POST['url_git_hardis'] != null
        ) {
            //chargement du fichier project.json et convertie en variable php
            $strdata = file_get_contents(__dir__ . '/../data/project.json');
            $json_data = json_decode($strdata, true);
            //Recherche de l'id le plus haut
            if (end($json_data) != false) {
                $idProject = end($json_data)['idProject'] += 1;
            } else {
                $idProject = 0;
            }
            //var_dump();die;
            //création de la variable PHP contenant le nouveau projet
            $projet_json = array('idProject' => $idProject, 'nomProject' => $_POST['projectName'], 'url_git_hardis' => $_POST['url_git_hardis'], 'url_git_client' => $_POST['url_git_client'], 'fileNameLogo' => $_FILES['logo']['name']);
            //remplace le contenu du fichier
            //Cas ou le fichier n'est pas créer ou qu'il est vide
            if (!$strdata || strlen($strdata) == 0) {
                $json_data = array($projet_json);
            } else {
                //concaténation de la variable PHP contenant le nouveau projet et des anciens projets
                array_push($json_data, $projet_json);
            }
            //var_dump($_FILES['logo']);die;
            file_put_contents(__dir__ . '/../data/project.json', json_encode($json_data));
            //Création de l'arborescence de donnée du projet
            mkdir(__dir__ . '/../data/' . $projet_json['idProject'], '0700');
            mkdir(__dir__ . '/../data/' . $projet_json['idProject'] . '/livraison', '0700');
            mkdir(__dir__ . '/../data/' . $projet_json['idProject'] . '/img', '0700');
            //Upload de le logo dans le fichier image du projet
            $tmp_name = $_FILES["logo"]["tmp_name"];
            move_uploaded_file($tmp_name, __dir__ . '/../data/' . $projet_json['idProject'] . '/img/logo.png');
        }
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $elem) {
                if ($elem != "." && $elem != "..") {
                    $this->rrmdir($dir . '/' . $elem);
                }
            }
        } else {
            $res = unlink($dir);
        }
        //chargement du fichier project.json et convertie en variable php
        $strdata = file_get_contents(__dir__ . '/../data/project.json');
        $json_data = json_decode($strdata, true);

        for ($i = 0; $i < count($json_data); $i++) {
            //supprime le projet dans le json ou l'id est recu en GET
            if ($json_data[$i]["idProject"] == $_GET['id']) {
                unset($json_data[$i]);
                $json_data = array_merge(array(), $json_data);
                file_put_contents(__dir__ . '/../data/project.json', json_encode($json_data));
            }
        }
        return rmdir($dir);
    }

    public function modifyProject()
    {
        //chargement du fichier project.json et convertie en variable php
        $strdata = file_get_contents(__dir__ . '/../data/project.json');
        $json_data = json_decode($strdata, true);
        for ($i = 0; $i < count($json_data); $i++) {
            if ($json_data[$i]['idProject'] == $_GET['id']) {
                print_r($json_data[$i]);
                //Changement du nom de projet si il est saisi
                if (isset($_POST['projectName']) && $_POST['projectName'] != null) {
                    $json_data[$i]['nomProject'] = $_POST['projectName'];
                }
                //Changement du versioning du projet si il est saisi
                if (isset($_POST['projectVersioning']) && $_POST['projectVersioning'] != null) {
                    $json_data[$i]['versioning'] = $_POST['projectName'];
                }
                //Changement de l'image de projet si il est saisi
                if (isset($_FILES['logo']) && $_FILES['logo'] != null) {
                    //remplace le logo dans le fichier json
                    $json_data[$i]['fileNameLogo'] = $_FILES['logo']['name'];
                    //Upload le logo dans le dossier img du projet (Remplace l'ancienne)
                    $tmp_name = $_FILES["logo"]["tmp_name"];
                    $test = move_uploaded_file($tmp_name, __dir__ . '/../data/' . $_GET['id'] . '/img/logo.png');
                }
                file_put_contents(__dir__ . '/../data/project.json', json_encode($json_data));
            }
        }
        //projectName, projectVersioning, logo
    }

    public function getGitBranch($path)
    {
        $cmd = "\"C:/Program Files/Git/bin/git.exe\" -C $path branch -r";
        exec($cmd, $output);
        return $output;
    }
}



