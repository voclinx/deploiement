<?php
include "menu.php";
?>
<div class="right_col" role="main">
    <?php

    // Variables d'initialisations
    $validation = isset($_SESSION['validation']) ? $_SESSION['validation'] : 0;
    unset($_SESSION['validation']);

    $data = isset($_SESSION["post"]) ? json_decode($_SESSION["post"], true) : null;
    unset($_SESSION["post"]);

    $erreurs = isset($_SESSION["errors"]) ? $_SESSION["errors"] : array();
    unset($_SESSION["errors"]);

    $_SESSION['livraison']=true;

    // Type de formulaire
    if ($_GET['action'] == "modifierLivraison") {
        $lib_btn_submit = 'Modifier';
        print '<form action="index.php?action=modifieraction&id=' . $_GET['id'] . '" method="post">';
        print '<input type="hidden" name="id" value="' . $_GET['id'] . '"';
    }else{
        $lib_btn_submit = 'Créer';
        print '<form action="index.php?action=createaction" method="post">';
    }

    // Listage des erreurs
    foreach ($erreurs as $erreur) : ?>
        <div class="alert alert-danger" role="alert" xmlns="http://www.w3.org/1999/html">
            <strong>Erreur!</strong> <?php print $erreur ?>
        </div>
    <?php endforeach; ?>

    <!-- top tiles -->
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <?php
            print('<span class="count_top"><i class="fa fa-user"></i> Livraison ' . $_SESSION['nameProject'] . '</span>');
            ?>
        </div>
    </div>
    <div class="jumbotron row ">
        <div class="col-md-6">
            <strong>Informations client </strong>
            <div class="row">
                <div class="col-md-2">Nom du client</div>
                <div class="input-group col-md-8">
                    <input type="text" name="nom_client"
                           value="<?php if ($validation == 1 and isset($data["nom_client"])) {
                               print $data["nom_client"];
                           } ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">Signature du client</div>
                <div class="input-group col-md-8">
                    <input type="text" name="signature_client"
                           value="<?php if ($validation == 1 and isset($data["signature_client"])) {
                               print $data["signature_client"];
                           } ?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <?php if ($_GET["action"] == 'modifierLivraison') : ?>
                <strong> Rapport de la Livraison</strong>
                <div class="radio">
                    <label><input type="radio" name="rapport"
                                  value="succes" <?php if (isset($data['rapport']) and $data['rapport'] == 'succes') print 'checked="checked"'; ?>>Succès</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="rapport"
                                  value="Warning" <?php if (isset($data['rapport']) and $data['rapport'] == 'Warning') print 'checked="checked"'; ?>>Alerte</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="rapport"
                                  value="Erreur" <?php if (isset($data['rapport']) and $data['rapport'] == 'Erreur') print 'checked="checked"'; ?>>Erreur</label>
                </div>
            <?php endif; ?>

            <div class="form-group ">
                <label for="comment">Commentaires du rapport de la Livraison</label>
                <textarea class="form-control" rows="2" id="commentaire_rapport"
                          name="commentaire_rapport"><?php if ($validation == 1 and isset($data["commentaire_rapport"])) print $data["commentaire_rapport"] ?></textarea>
            </div>
        </div>
    </div>
    <!-- /top tiles -->
    <div class="jumbotron row">
        <strong>ENVIRONNEMENT</strong><br/>
        <?php
        if (count($branch['hardis']) != 0) {

            foreach ($branch['hardis'] as $item) {
                $trimmed = ucfirst(substr(strrchr($item,'/'),1));
                print('<div class="radio">');
                print('<label><input type="radio" name="environnement" VALUE="' . $trimmed . '"');
                if (isset($data['environnement']) && $data['environnement'] == $trimmed && $validation == 1) {
                    print('checked="checked"');
                }
                if ($_GET['action'] == "modifierLivraison") {
                    print('onclick="return false;"');
                }
                print(' >' . $trimmed . '</label></div>');
            }
        }else{
            $check = (isset($data['environnement']) && $data['environnement'] == 'Production' && $validation == 1)?('checked="checked" '):('');
            $click = ($_GET['action'] == "modifierLivraison")?('onclick="return false;"'):('');
            print('<div class="radio"><label><input type="radio" name="environnement" VALUE="Production"'.$check.$click.'>Production</label></div>');

            $check = (isset($data['environnement']) && $data['environnement'] == 'Preproduction' && $validation == 1)?('checked="checked" '):('');
            $click = ($_GET['action'] == "modifierLivraison")?('onclick="return false;"'):('');
            print('<div class="radio"><label><input type="radio" name="environnement" VALUE="Preproduction"'.$check.$click.'>Preproduction</label></div>');
            $click = ($_GET['action'] == "modifierLivraison")?('onclick="return false;"'):('');

            $check = (isset($data['environnement']) && $data['environnement'] == 'recette' && $validation == 1)?('checked="checked" '):('');
            print('<div class="radio"><label><input type="radio" name="environnement" VALUE="recette"'.$check.$click.'>recette</label></div>');
        }


        ?>
        <!--
        <div class="radio">
            <label><input type="radio" name="environnement"
                          VALUE="Recette" <?php //if (isset($data['environnement']) and ($data['environnement'] == 'Recette') and ($validation == 1)) print 'checked="checked"'; ?> <?php //if ($_GET['action'] == "modifierLivraison") print('onclick="return false;"') ?> >Recette</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="environnement"
                          VALUE="Preproduction" <?php //if (isset($data['environnement']) and ($data['environnement'] == 'Preproduction') and ($validation == 1)) print 'checked="checked"'; ?> <?php //if ($_GET['action'] == "modifierLivraison") print('onclick="return false;"') ?>>Preproduction</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="environnement"
                          VALUE="Production" <?php //if (isset($data['environnement']) and ($data['environnement'] == 'Production') and ($validation == 1)) print 'checked="checked"'; ?> <?php //if ($_GET['action'] == "modifierLivraison") print('onclick="return false;"') ?>>Production</label>
        </div>
-->
        <strong>Type de Livraison</strong>

        <div class="checkbox">
            <label><input type="checkbox" name="type_livraison" id="type_livr_1"
                          VALUE="1" <?php if (isset($data['type_livraison']) and ($data['type_livraison'] == '1') and ($validation == 1)) print 'checked="checked"'; ?> <?php if ($_GET['action'] == "modifierLivraison") print('onclick="return false;"') ?>>Evolution</label>
        </div>

        <div class="checkbox">
            <label><input type="checkbox" name="type_livraison" id="type_livr_2"
                          VALUE="2" <?php if (isset($data['type_livraison']) and ($data['type_livraison'] == '2') and ($validation == 1)) print 'checked="checked"'; ?> <?php if ($_GET['action'] == "modifierLivraison") print('onclick="return false;"') ?>>Correction</label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="type_livraison" id="type_livr_3"
                          VALUE="3" <?php if (isset($data['type_livraison']) and ($data['type_livraison'] == '3') and ($validation == 1)) print 'checked="checked"'; ?> <?php if ($_GET['action'] == "modifierLivraison") print('onclick="return false;"') ?>>Bugfix</label>
        </div>
        <?php if ($_GET["action"] == 'createlivraison') : ?>
            <div class="row">
                <div class="col-md-2">Ancienne Version</div>
                <div class="input-group col-md-8">
                    <input type="text" name="AncienneVersion" readonly="readonly"
                    >
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-2">Version</div>
            <div class="input-group col-md-8">
                <input <?php if ($_GET['action'] == "modifierLivraison") print('readonly') ?> type="text"
                                                                                              name="version"
                                                                                              value="<?php if ($validation == 1 and isset($data['version'])) print $data["version"]; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="comment">Commentaires:</label>
            <textarea class="form-control" rows="9" id="commentaires"
                      name='commentaires'><?php if ($validation == 1 and isset($data["commentaires"])) print $data["commentaires"] ?></textarea>
        </div>
        <div class="form-group">
            <label for="comment">Instructions</label>
            <textarea class="ckeditor" rows="20" id="instructions"
                      name='instructions'><?php if ($validation == 1 and isset($data["instructions"])) print $data["instructions"] ?></textarea>
        </div>
        <div class="form-group">
            <label for="comment">ANNEXE</label>
            <textarea class="ckeditor" rows="20" id="annexe"
                      name='annexe'><?php if ($validation == 1 and isset($data["annexe"])) print $data["annexe"] ?></textarea>
        </div>
    </div>

    <input type="hidden" name="statut" value="pending">
    <input type="hidden" name="installation" value="">
    <input type="hidden" name="commentaires_retours_installation" value="">
    <input class="btn btn-primary btn-lg text-center" type="submit" value="<?php print $lib_btn_submit ?>">

    </form>
</div>