//la valeur de ancienne version
$(document).ready(function () {
    $('input[name="environnement"]').change(function () {
        var userID = $(this).attr('value');
        var version = $('input[name="version"]').attr('value');
        var ancienneversion = null;


        $.ajax({
            method: "POST",
            url: "ajax.php",
            //data: { "userID": userID },
            dataType: 'json'
        })
            .done(function (data, textStatus, jqXHR) {
                $('input[name="AncienneVersion"]').val('');
                $('input[name="version"]').val('');
                data.forEach(function (element) {
                    if (element['environnement'] == userID) {
                        ancienneversion = element['version'];
                        $('input[name="AncienneVersion"]').val(ancienneversion);
                        $('input[name="version"]').val(ancienneversion);
                        init_num_version();
                    }
                })
            })

    });

    //Type de livraison
    $('input[name="type_livraison"]').change(function () {
        init_num_version();
    });
});

function init_num_version() {
    var version = $('input[name="AncienneVersion"]').val();
    var evol = document.getElementById('type_livr_1').checked;
    var correction = document.getElementById('type_livr_2').checked;
    var bugfix = document.getElementById('type_livr_3').checked;
    $.ajax({
        method: "POST",
        url: "ajax/ajax.php",
        data: {
            version: version,
            evol: evol,
            correction: correction,
            bugfix: bugfix,
        },
    })
        .done(function (data) {
            $('input[name="version"]').val(data);
        })
}


