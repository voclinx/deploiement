<?php
class model_livraison{
    function run(){
        $strdata = file_get_contents(__dir__.'/../data/'.$_GET['id']);
        $data = json_decode($strdata,true);
        var_dump($data);

        $env = strtolower($data['environnement']);

        call_user_func(array($this,'push_'.$env),array($data['version']));
    }

    function push_recette($version){

        $SVN = "https://pid.hardis.fr/svn/opcaim/livraison-collecte-bleu/";
        $env = "master";
        $env_lib_obj = "RECETTE";
        $export = "OPCAIM-EXTRANET-MASTER";
        $this->push($version,$SVN,$env,$env_lib_obj,$export);
    }

    function push_production($version){

        $SVN = "https://pid.hardis.fr/svn/opcaim/livraison-production/";
        $env = "production";
        $env_lib_obj = "PRODUCTION";
        $export = "OPCAIM-EXTRANET-PRODUCTION";

        $this->push($version,$SVN,$env,$env_lib_obj,$export);
    }
    function push_preproduction($version){

        $SVN = "https://pid.hardis.fr/svn/opcaim/livraison-collecte-vert/";
        $env = "production";
        $env_lib_obj = "PREPRODUCTION";
        $export = "OPCAIM-EXTRANET-PREPRODUCTION";

        $this->push($version,$SVN,$env,$env_lib_obj,$export);
    }

    function push($version,$SVN,$env,$env_lib_obj,$export ){

        if ($version){
            include('/Sources/yocto_api.php');
            include('/Sources/yocto_relay.php');

            // Use explicit error handling rather than exceptions
            yDisableExceptions();

            // Setup the API to use the VirtualHub on local machine
            if (yRegisterHub('192.168.78.245:4445/', $errmsg) != YAPI_SUCCESS) {
                die("Cannot contact VirtualHub on 127.0.0.1");
            }

            @$serial = $_GET['serial'];
            if ($serial != '') {
                // Check if a specified module is available online
                $relay = yFindRelay("$serial.relay1");
                if (!$relay->isOnline()) {
                    die("Module not connected (check serial and USB cable)");
                }
            } else {
                // or use any connected module suitable for the demo
                $relay = yFirstRelay();
                if (is_null($relay)) {
                    die("No module connected (check USB cable)");
                } else {
                    $serial = $relay->module()->get_serialnumber();
                }
            }
            Print("Module to use: $serial");

            $relay->set_state(Y_STATE_B);
sleep(10);
/*
            $dest = "https://pid.hardis.fr/svn/opcaim/tags/livraison-$env/v".$version;
        //	$cmd = "svn delete ".$dest."/ -m 'delete tag'";

            $cmd = "svn copy $SVN  ".$dest. " -m 'livraion'";
            customExec($cmd);

            // on fait un pull avant tout
            $cmd = "git -C $export pull ";
            customExec($cmd);

            $cmd = "svn export $dest $export --force";
            customExec($cmd);

            $footer = file_get_contents($export."/sites/all/themes/opcaim/templates/footer.tpl.php");

            $footer = str_replace("LIV_VERSION" , $version , $footer);

            file_put_contents($export."/sites/all/themes/opcaim/templates/footer.tpl.php",$footer);

            $cmd = "git -C $export add .";
            customExec($cmd );

            $cmd = "git -C $export status";
            customExec($cmd ,$mail,true);

            $cmd = "git -C $export commit -a -m '$version'";
            customExec($cmd );

            $cmd = "git -C $export tag -a $version -m 'tag'";
            customExec($cmd );

            $cmd = "git -C $export push origin $version";
            customExec($cmd );

            $cmd = "git -C $export push ";
            customExec($cmd ,$mail,true);
*/
     //       mail("dreamteam.web@hardis.fr","Livraison ".$env_lib_obj. " " .$version,$mail);
            $relay->set_state(Y_STATE_A);
        }
    }
}
function customExec($cmd,&$mail=null,$print=false){
    $str =  "---------------------------------------------\n";
    print $cmd."\n";
    exec($cmd ,$output);
    $str .= implode("\n",$output);
    $str .= "\n---------------------------------------------\n";
    if($print){
        $mail.=$str;
    }
    print $str;
}