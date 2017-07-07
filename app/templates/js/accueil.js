jQuery(document).ready(function () {
    jQuery(".glyph_del").click(function (e) {
        action_link(this, 'deleteProject', 'deleteProject');
    });
    jQuery(".glyph_edit").click(function (e) {

        jQuery(".modal-title").text('Modifier un projet');
        jQuery("#project_name").removeAttr("required");
        action_link(this, 'add_edit', 'modifyProject');
        jQuery("#button_submit").text('Modifier');
        var form = jQuery("#add_edit_Project_form");
        form.removeAttr('name');
        form.attr('name', 'edit_project');


        $.ajax({
            method: "POST",
            url: "app/templates/js/ajax/ajax_log_json.php",
            dataType: 'json'
        })
            .done(function (data) {
                data.forEach(function (element) {
                    if (element['projectId'] == id) {

                        if (typeof element['loginClient'] !== 'undefined') {
                            $('input[name="loginClient"]').attr('placeholder', element['loginClient']);
                            // $('input[name="loginClient"]').val(element['loginClient']);
                        }
                        if (typeof element['loginHardis'] !== 'undefined') {
                            $('input[name="loginHardis"]').attr('placeholder', element['loginHardis']);
                            // $('input[name="loginHardis"]').val(element['loginHardis']);
                        }
                        if (typeof element['projectName'] !== 'undefined') {
                            $('input[name="projectName"]').attr('placeholder', element['projectName']);
                            // $('input[name="projectName"]').val(element['projectName']);
                        }
                        if (typeof element['url_git_hardis'] !== 'undefined') {
                            $('input[name="url_git_hardis"]').attr('placeholder', element['url_git_hardis']);
                            // $('input[name="url_git_hardis"]').val(element['url_git_hardis']);
                        }
                        if (typeof element['url_git_client'] !== 'undefined') {
                            $('input[name="url_git_client"]').attr('placeholder', element['url_git_client']);
                            // $('input[name="url_git_client"]').val(element['url_git_client']);
                        }
                    }
                });


            })

    });
    jQuery(".buttonAddProject").click(function (e) {
        jQuery('input').attr("placeholder","");
        jQuery(".modal-title").text('Ajouter un projet');
        jQuery("#project_name").prop("required", "true");
        var form = jQuery("#add_edit_Project_form");
        form.attr('action', 'index.php?action=createProject');
        form.removeAttr('name');
        form.attr('name', 'add_project');
        jQuery("#button_submit").text('Créer');
    });
});


// Spécification de l'id projet dans le lien d'action
function action_link(elem, name, type) {
    id = jQuery(elem).attr('data-id');
    link = 'index.php?action=' + type + '&id=' + id;
    jQuery('form[name="' + name + '"]').attr('action', link);

}
