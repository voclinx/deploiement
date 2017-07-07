// la valeur de ancienne version
$(document).ready(function () {
    $('input[name="environnement"]').change(function () {
        var userID = $(this).attr('value');
        var version = $('input[name="version"]').attr('value');
        var ancienneversion = null;
        $.ajax({
            method: "POST",
            url: "app/templates/js/ajax/create_init_last_vers.php",
            data: {
                environnement : env
            }
        }).success(function (data) {
            $('input[name="lastVersion"]').val('');
            data.forEach(function (element) {
                if (element['environnement'] === userID) {
                    ancienneversion = element['version'];
                    $('input[name="AncienneVersion"]').val(ancienneversion);
                    $('input[name="version"]').val(ancienneversion);
                    init_num_version();
                }
            });
        });

    });

    //Type de livraison
    $('input[name="type_livraison"]').change(function () {
        init_num_version();
    });
});
