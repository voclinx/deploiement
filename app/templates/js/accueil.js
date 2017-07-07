/**
 * Created by YCo on 07/04/2017.
 */
jQuery(document).ready(function(){
    jQuery(".glyph_del").click(function(e){
        action_link(this, 'deleteProject', 'deleteProject');
    });
    jQuery(".glyph_edit").click(function(e){
        jQuery(".modal-title").text('Modifier un projet');
        action_link(this, 'add_edit', 'modifyProject');
        jQuery("#button_submit").text('Modifier');
    });
    jQuery(".buttonAddProject").click(function(e){
        jQuery(".modal-title").text('Ajouter un projet');
        jQuery("#add_edit_Project_form").attr('action','index.php?action=createProject');
        jQuery("#button_submit").text('Créer');
    });
});



// Spécification de l'id projet dans le lien d'action
function action_link(elem, name, type){
    id = jQuery(elem).attr('data-id');
    link = 'index.php?action=' + type + '&id=' + id;
    jQuery('form[name="' + name + '"]').attr('action',link);
}
