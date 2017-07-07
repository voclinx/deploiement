<?php include "menu.php"; ?>
<div id="loader" class="loader">
    <img class="img-loader" src="./build/css/loading-gif1.gif"/>
</div>
<div class="right_col" role="main">
    <form action="index.php?action=historique" method="post">

        <div class="right_col" role="main">
            <div class="">


                <div class="row">

                    <div class="clearfix"></div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">

                                <?php
                                print('<h2>Historique de déploiement <small>' . $_SESSION['nameProject'] . '</small></h2>');
                                ?>

                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                           aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Settings 1</a>
                                            </li>
                                            <li><a href="#">Settings 2</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>

                            <div class="x_content">


                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                        <tr class="headings">
                                            <!-- <th>
                                                 <input type="checkbox" id="check-all" class="flat">
                                             </th>-->
                                            <th class="column-title"></th>
                                            <th class="column-title">Environnement</th>
                                            <th class="column-title">Date</th>
                                            <th class="column-title">Version</th>
                                            <th class="column-title"></th>
                                            <th class="column-title"></th>
                                            <th class="column-title"></th>
                                            <th class="column-title"></th>
                                            <th class="column-title"></th>
                                            <th class="column-title"></th>
                                            <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions (
                                                    <span
                                                            class="action-cnt"> </span> ) <i
                                                            class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <?php

                                        foreach ($data as $value) {

                                            if ($value != '.' && $value != "..") {

                                                $aLivraison = explode("-", $value);
                                                ?>
                                                <tr class="even pointer">
                                                    <td class="a-center ">
                                                        <input type="checkbox" class="flat" name="table_records">
                                                    </td>
                                                    <td class=" "><?php print ucfirst($aLivraison[1]); ?></td>
                                                    <td class=" "><?php print date('Y-m-d H:i:s', $aLivraison[0]) ?></td>
                                                    <td class=" "><?php print $aLivraison[2] ?></td>

                                                    <?php
                                                    if (!isset($_SESSION[$value])): ?>
                                                        <!--                                                        <td>d7175a797bf21c47e7cc96d5fd99483720ca2937</td>-->
                                                        <td>
                                                            <a href="index.php?action=supression&id=<?php print $value; ?>">
                                                        <span class="glyphicon glyphicon-trash"
                                                              aria-hidden="true"
                                                              data-target="#confirmDelete" title="Supprimer"></span></a>
                                                        </td>
                                                    <?php else: ?>
                                                        <th class="column-title"></th>
                                                    <?php endif; ?>

                                                    <td><span class="glyphicon glyphicon-search" aria-hidden="true"
                                                              title="Chercher"></span>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?action=modifierLivraison&id=<?php print $value; ?>"<span
                                                                class="glyphicon glyphicon-pencil"
                                                                aria-hidden="true" title="Modifier"></span></a></td>
                                                    <td>
                                                        <?php if($controler->getDeployment($value)): ?>
                                                            <a class="glyph-deploy disable">
                                                                <span class="glyphicon glyphicon-fire"></span>
                                                            </a>
                                                        <?php else: ?>
                                                            <a class="glyph-deploy" data-toggle="modal"
                                                               data-target="#deployerProject"
                                                                data-id="<?php print $value; ?>">
                                                                <span class="glyphicon glyphicon-fire" aria-hidden="true" title="Déployer"></span>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?action=bordereau&id=<?php print $value; ?>"><span
                                                                    class="glyphicon glyphicon-circle-arrow-down"
                                                                    aria-hidden="true"
                                                                    title="Télécharger le bordereau "></span></a>
                                                    </td>

                                                    <td><a id="<?php print $value; ?>" class="status-deploy" href="#"><span
                                                                    class="glyphicon glyphicon-info-sign"
                                                                    aria-hidden="true" title=""></span>
                                                        </a>
                                                        <div id="<?php print $value; ?>" class="info-deploiement">
                                                            <p>Déploiement : </p>
                                                            <ul>
                                                                <li>Commit ID : <?php print $controler->getCommitId($value); ?></li>
                                                                <li>Date : <?php print $controler->getDateDeployment($value); ?></li>
                                                                <li>Etat : <?php print $controler->getRapportLivraison($value); ?></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?>


                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Modal de demande de login et password pour deployer-->
    <div id="deployerProject" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal">&times;
                    </button>

                    <h4 class="modal-title">Déploiement</h4>
                </div>
                <form class="form-horizontal" name="form-deploiement" method="POST" action="">
                    <div class="modal-body">
                        <div class="row">
                            <?php if ($db->checkDataDeploye($_SESSION['idProject'], 'hardis')): ?>
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
                            <?php endif; ?>

                            <?php if ($db->checkDataDeploye($_SESSION['idProject'], 'client')): ?>
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
                            <?php endif; ?>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4>Branche GIT Hardis</h4>
                                <ul>
                                    <?php
                                    foreach ($branches['hardis'] as $branch) {
                                        $branch = strrchr($branch, '/');
                                        print('<li>' . $branch . '</li>');
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4>Branche GIT Client</h4>
                                <?php
                                foreach ($branches['client'] as $branch) {
                                    $branch = strrchr($branch, '/');
                                    print('<li>' . $branch . '</li>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="environnement">Environnement :</label>
                            <input class="form-control" name="environnement" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="environnement">Tag :</label>
                            <input class="form-control" name="vers" type="text" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deploiement-bt" class="btn btn-default pull-right" type="submit">Valider
                        </button>
                        <a data-toggle="modal" data-target="#modifierGit">
                            <button class="btn btn-default pull-right">Modifier dépôt Git</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal de modification de login, password, url de projet-->
    <div id="modifierGit" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="title_modal" class="modal-title">Configuration du
                        GIT: <?php print $_SESSION['nameProject']; ?></h4>
                </div>
                <form id="add_edit_Project_form" class="form-horizontal" name="add_edit" method="POST"
                      enctype="multipart/form-data" action="index.php?action=modifyProject">
                    <div class="modal-body">
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
                            <input name="redirect" type="hidden" value="true">
                        </div>
                        <div class="modal-footer">
                            <button id="button_submit" class="btn btn-default pull-right" type="submit">Modifier
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="app/templates/js/deploiement.js"></script>
