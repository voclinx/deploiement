<?php
/**
 * Created by PhpStorm.
 * User: YCo
 * Date: 18/04/2017
 * Time: 14:15
 */

namespace Cz\Git;

namespace SebastianBergmann\Git;

use Cz\Git\GitRepository;

require __DIR__ . "\\..\\..\\vendor\\autoload.php";

$env = $argv[3];
$login = $argv[1];
$password = $argv[2];
$version = $argv[4];
/*
//Variable de test
$env = 'production';
$login = 'Voclinx';
$password = '123456789';
$version = date('H:i:s');
*/
$UrlGitClient = 'https://' . $login . ':' . $password . '@gitlab.com/Voclinx/OPCAIM.git';
$repClient = __DIR__ . '\\..\\..\\..\\srv_deploiement\\srv_client\\0\\' . $env;/*.$_SESSION['idProject']*/

$loginHardis = 'ycourard'; // A changer
$passwordHardis = 'Delta1994'; // A changer
$UrlGitHardis = 'https://' . $loginHardis . ':' . $passwordHardis . '@pid.hardis.fr/git/r/OPCAIM.git';
$repHardis = __DIR__ . '\\..\\..\\..\\srv_deploiement\\srv_hardis\\0\\'/*.$_SESSION['idProject']*/;

$git = "D:\Git\bin\git.exe";

//Si le repertoire de developpement n'existe pas on le crée
if (!file_exists($repHardis)) {
    mkdir(__DIR__ . '\\..\\..\\..\\srv_deploiement\\srv_hardis\\0');
    $repo = GitRepository::cloneRepository($UrlGitHardis, $repHardis);
}

//Si le repertoire du site client n'existe pas on le crée
if (!file_exists($repClient . '/../')) {
    mkdir(__DIR__ . '\\..\\..\\..\\srv_deploiement\\srv_client\\0');/*.$_SESSION['idProject']*/
}

//Si le repertoire de la branche du client n'existe pas on le crée.
if (!file_exists($repClient)) {
    $repo = GitRepository::cloneRepository($UrlGitClient, $repClient);
    $gitClient = new Git($repClient);
    $gitClient->config('user.name', 'User natotome');
    $gitClient->config('user.email', 'user@example.com');
} else {
    $gitClient = new Git($repClient);
}

if ($version) {
    // on fait un pull avant tout
    $cmd = $git . " -C " . $repClient . " pull ";
    customExec($cmd);

    //change branch
    $cmd = $git . " -C $repClient checkout " . $env;
    customExec($cmd);
    $cmd = $git . " -C $repHardis checkout " . $env;
    customExec($cmd);

    //change branch
    $cmd = $git . " -C $repClient pull origin " . $env;
    customExec($cmd);
    $cmd = $git . " -C $repHardis checkout " . $env;
    customExec($cmd);

    //destination the file to the destination
    $cmd = $git . " -C $repHardis checkout-index -a -f --prefix=" . $repClient . '\\';
    customExec($cmd);

    $gitClient->add(array('.'));

    $cmd = $git . " -C $repClient status";
    customExec($cmd, $mail, true);

    $gitClient->commit($version);

    $cmd = $git . " -C $repClient tag -a $version -m 'tag'";
    customExec($cmd);

    $cmd = $git . " -C $repClient push origin $version";
    customExec($cmd);

    $gitClient->push();


    exit;
}
function customExec($cmd, &$mail = null, $print = false)
{
    $str = "---------------------------------------------<br />" . $cmd . "<br />";
    exec($cmd, $output);
    $str .= implode("<br />", $output);
    $str .= "<br />---------------------------------------------<br />";

    if ($print) {
        $mail .= $str;
    }
    print $str;
}