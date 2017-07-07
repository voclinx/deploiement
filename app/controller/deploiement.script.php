<?php
/**
 * Created by PhpStorm.
 * User: YCo
 * Date: 18/04/2017
 * Time: 14:15
 */

require_once 'db.php';
include __DIR__ . "/../config/environnement_path.php";

$db = new db();

//ré-insertion de l'espace dans la version
$env = str_replace("\\n", " ", $argv[1]);

$version = $argv[2];
$projectId = $argv[3];
$log = $db->getLog($projectId);

$loginClient = $log['loginClient'];
$passwordClient = $log['pwdClient'];
$loginHardis = $log['loginHardis'];
$passwordHardis = $log['pwdHardis'];
$url = $db->getUrlGit($projectId);

$gitClient = $url['client'];
$gitHardis = $url['hardis'];

$UrlGitClient = 'https://' . $loginClient . ':' . $passwordClient . $gitClient;
$repClient = __DIR__ . '/../../../srv_deploiement/srv_client/' . $projectId . '/' . $env . '/';

$git = GIT;

$UrlGitHardis = 'https://' . $loginHardis . ':' . $passwordHardis . $gitHardis;
$repHardis = __DIR__ . '/../../../srv_deploiement/srv_hardis/' . $projectId;


//Si le repertoire de developpement n'existe pas on le crée
if (!file_exists($repHardis)) {
    mkdir(__DIR__ . '/../../../srv_deploiement/srv_hardis/' . $projectId, 0700, true);
}

// on fait un clone du projet coter hardis
if (!file_exists($repHardis . '/.git'))
    $cmd = "$git -C $repHardis clone $UrlGitHardis .";
else
    $cmd = "$git -C $repHardis pull";
customExec($cmd);

//Si le repertoire du site client n'existe pas on le crée
if (!file_exists(__DIR__ . '/../../../srv_deploiement/srv_client/' . $projectId . '/')) {
    mkdir(__DIR__ . '/../../../srv_deploiement/srv_client/' . $projectId . '/', 0700, true);
}

//Si le repertoire de la branche du client n'existe pas on le crée.
if (!file_exists($repClient) || !(file_exists($repClient . '.git'))) {
    // on fait un clone du projet coter client
    $cmd = "$git clone $UrlGitClient $repClient";
    customExec($cmd);
    // on configure le nom de l'utilisateur git
    $cmd = "$git -C $repClient config user.name \"Application Deploiement\"";
    customExec($cmd);
    // on configure le mail de l'utilisateur git
    $cmd = "$git -C $repClient config user.email \"user@example.com\"";
    customExec($cmd);

}

if ($version) {
    /* $env = "recette";
     $env_lib_obj = "RECETTE";


     $gitDepot = "http://ycourard@pid.hardis.fr/git/r/OPCAIM.git"; //hardis
     $pathDepot = 'D:\workspace\OPCAIM'; //hardis
     $export = "OPCAIM-EXTRANET-RECETTE"; //opcaim
     $destination = 'D:\workspace\deployer\\' . $export . '\\'; // opcaim

     $version = $argv[1];*/

    // on fait un pull avant tout
    $cmd = "$git -C $repClient pull ";
    customExec($cmd);


    //change branch
    $cmd = "$git -C $repClient checkout " . $env;
    customExec($cmd);

    //change branch
    $cmd = "$git -C $repHardis checkout " . $env;
    customExec($cmd);

    if(isset($argv[4])&&$argv[4]!=null){
        $cmd = 'find "'. $repClient .'" -maxdepth 1 -mindepth 1 -not -name ".git" -exec rm -rf {} \;';
        exec($cmd, $output);

        //positionne le pointeur de GIT sur l'id de commit désiré
        $cmd = "$git -C $repHardis checkout " . $argv[4];
        customExec($cmd);
    }else{
        $cmd = $git.' -C '.$repHardis .' tag ' . $version;
        customExec($cmd);
    }

    //change branch
    $cmd = "$git -C $repClient pull origin " . $env;
    customExec($cmd);

    //export the file to the destination
    $cmd = "$git -C $repHardis checkout-index -a -f --prefix=" . $repClient;
    customExec($cmd);

    /*
            $footer = file_get_contents($export . "/sites/all/themes/opcaim/templates/footer.tpl.php");
            $array_footer = explode('<!--DEPLOIEMENT_NUM-->', $footer);
            $footer = $array_footer[0] . "<!--DEPLOIEMENT_NUM-->Version " . $version . "<!--DEPLOIEMENT_NUM-->" . $array_footer[2];
            file_put_contents($export . "/sites/all/themes/opcaim/templates/footer.tpl.php", $footer);
    */
    $cmd = "$git -C $repClient add .";
    customExec($cmd);

    $cmd = "$git -C $repClient status";
    customExec($cmd, $mail, true);

    $cmd = "$git -C $repClient commit -a -m '$version'";
    customExec($cmd);

    $cmd = "$git -C $repClient tag -a $version -m 'tag'";
    customExec($cmd);

    $cmd = "$git -C $repClient config --global push.default matching";
    customExec($cmd);

    $cmd = "$git -C $repClient push origin $version";
    customExec($cmd);

    $cmd = "$git -C $repClient push ";
    customExec($cmd, $mail, true);

//        mail("yohan.courard@hardis.fr", "Livraison " . $env_lib_obj . " " . $version, $mail);

    exit;
}
function customExec($cmd, &$mail = null, $print = false)
{
    $str = "---------------------------------------------<br />" . $cmd . "<br />";
    exec($cmd, $output);
    $str .= implode("<br />", $output);
    $str .= "<br />---------------------------------------------<br />";

//    if ($print) {
//        $mail .= $str;
//    }
    return $str;
}
