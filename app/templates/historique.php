<?php include "menu.php"; ?>
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
                                                    <td class=" "><?php print $aLivraison[1] ?></td>
                                                    <td class=" "><?php print date('Y-m-d H:i:s', $aLivraison[0]) ?></td>
                                                    <td class=" "><?php print $aLivraison[2] ?></td>

                                                    <?php
                                                    if (!isset($_SESSION[$value])): ?>
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
                                                        <a data-toggle="modal"
                                                           data-target="#deleteProject">
                                                        <span class="glyphicon glyphicon-fire"
                                                              aria-hidden="true" title="Déployer"></span></a></td>
                                                    <td>
                                                        <a>
                                                            <span
                                                                    class="glyphicon glyphicon-circle-arrow-down"
                                                                    aria-hidden="true"
                                                                    title="Télécharger le bordereau ">
                                                            </span>
                                                        </a>
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
        <?php
        var_dump(__DIR__."\\..\\controller\\push-git-recette.php");
        ?>
    </form>
    <!-- Modal de demande de login et password pour deployer-->
    <div id="deleteProject" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal">&times;
                    </button>
                    <h4 class="modal-title">Déploiement</h4>
                </div>
                <form class="form-horizontal" name="log" method="POST" action="index.php?action=livraison">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="login">Login :</label>
                            <input class="form-control" name="login" type="text">
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe :</label>
                            <input class="form-control" name="password" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4>Branche GIT Hardis</h4>
                                <ul>
                                    <?php
                                    foreach ($branchHardis as $branch) {
                                        $branch = str_replace(array('*','origin','/',' ','HEAD->'),'', $branch);
                                        print('<li>' . $branch . '</li>');
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4>Branche GIT Client</h4>
                                <?php
                                foreach ($branchClient as $branch) {
                                    $branch = str_replace(array('*','origin','/',' ','HEAD->'),'', $branch);
                                    print('<li>' . $branch . '</li>');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="environnement">Environnement :</label>
                            <input class="form-control" name="environnement" type="text">
                        </div>
                        <div class="form-group">
                            <label for="environnement">Version :</label>
                            <input class="form-control" name="vers" type="text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default pull-right" type="submit">Valider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>