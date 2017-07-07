<?php
if (isset($_SESSION['idProject'])) {
    session_unset();
}
?>
<div class="jumbotron row ">
    <div class="accueil col-md-10 col-md-offset-2 col-md-offset-right-2">

    </div>
    <div class="row">
        <p class="text-center">Selectionner votre projet</p>
    </div>
    <div class="row" id="list_bouton_accueil">
        <?php

        // Parcours des projets crées dans l'application
        $compteur = 0;
        foreach ($data as $key) {
            //"../data/".$key["idProject"]."/img/".$key["fileNameLogo"]
            $path = __dir__ . '/../data/project/';
            if (file_exists($path . $key["projectId"] . '/img/logo.png')) {
		$imgURL = "app/data/project/".$key["projectId"]."/img/logo.png";
	    } else {
                $imgURL = "../../img/defaut.jpg";
            }
            print('<a href="../../index.php?action=index&idProject=' . $key['projectId'] . '&nameProject=' . $key['projectName'] . '">');
            if ($compteur == 0) {
                print('<div class="btn-accueil btn btn-default col-md-offset-2 col-md-2 col-sm-offset-2 col-sm-2 col-xs-offset-2 col-xs-2">');
            } else {
                // print('<a href="../../index.php?action=index&idProject="' . $key['idProject'] . '">');
                print('<div class="btn-accueil btn btn-default col-md-2 col-sm-2 col-xs-2">');
            }
            print('<img class="hidden-xs" src="' . $imgURL . '" height="100" width="100"></br>');
            print('<a   id="glyph_del" data-id="' . $key['projectId'] . '" class="glyph_del btn-xs btn-default" data-toggle="modal"
                        data-target="#deleteProject"><i class="fa fa-trash-o fa-fw"></i></a>');
            print('<a   id="glyph_edit" data-id="' . $key['projectId'] . '" class="glyph_edit btn-xs btn-default" data-toggle="modal" 
                        data-target="#add_edit_Project"><i class="fa fa-pencil fa-fw"></i></a>');
            print($key["projectName"]);
            print('</div>');
            print('</a>');
            $compteur++;
            //
            if ($compteur == 4) {
                $compteur = 0;
                print('</div><div class="row">');
            }
        }
        ?>
    </div>
    <br/>
    <div class="row">
        <!--        <a href="../../index.php?action=createProject">-->
        <!--            <button class="btn btn-default col-md-offset-5 col-md-2">Ajouter un projet</button>-->
        <!--        </a>-->
        <!-- Trigger the modal with a button -->
        <button type="button"
                class="btn btn-default col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2 col-xs-offset-4 col-xs-4 buttonAddProject"
                data-toggle="modal"
                data-target="#add_edit_Project">Ajouter un projet
        </button>

        <!-- Modal de confirmation de suppression de projet-->
        <div id="deleteProject" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Supprimer un projet</h4>
                    </div>
                    <form class="form-horizontal" name="deleteProject" method="POST"
                          enctype="multipart/form-data">
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir supprimer définitivement le projet ?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default pull-right" type="submit">Oui</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal d'ajout/modification de projet-->
        <div id="add_edit_Project" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id="title_modal" class="modal-title"></h4>
                    </div>
                    <form id="add_edit_Project_form" class="form-horizontal" name="add_edit" method="POST"
                          enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row form-group">
                                <label for="projectName">Nom :</label>
                                <input id="project_name" class="form-control" type="text" name="projectName">
                            </div>
                            <div class="form-group col-md-6 col-xs-6 col-sm-6 col-lg-6">
                                <fieldset>
                                    <legend>Configuration depôt Hardis :</legend>
                                    <div class="col-md-11">
                                        <div class="row">
                                            <label for="url_git_hardis">URL :</label>
                                            <input class="form-control" type="text" name="url_git_hardis">
                                        </div>
                                        <div class="row">
                                            <label class="" for="loginHardis">Login :</label>
                                            <input class="form-control" type="text" name="loginHardis">
                                        </div>
                                        <div class="row">
                                            <label for="pwdHardis">Password :</label>
                                            <input class="form-control" type="password"
                                                   name="pwdHardis">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="form-group col-md-6 col-xs-6 col-sm-6 col-lg-6">
                                <fieldset>
                                    <legend>Configuration depôt Client :</legend>
                                    <div class="col-md-11">
                                        <div class="row">
                                            <label for="url_git_hardis">URL :</label>
                                            <input class="form-control" type="text" name="url_git_client">
                                        </div>
                                        <div class="row">
                                            <label class="" for="loginHardis">Login :</label>
                                            <input class="form-control" type="text" name="loginClient">
                                        </div>
                                        <div class="row">
                                            <label for="pwdHardis">Password :</label>
                                            <input class="form-control" type="password"
                                                   name="pwdClient">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo :</label>
                                <input name="logo" class="form-control" type="file" accept="image/*" capture="camera"
                                       id="testFile" name="test">
                            </div>
                            <div class="modal-footer">
                                <button id="button_submit" class="btn btn-default pull-right" type="submit"></button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="app/templates/js/accueil.js"></script>
