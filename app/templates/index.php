<?php
    include "menu.php";
?>
<div class="right_col" role="main">
<?php
$valeur_recette_mars = 0;

$Recette_succes = 0;
$Recette_Warning = 0;
$Recette_Erreur = 0;
$Preproduction_succes = 0;
$Preproduction_Warning = 0;
$Preproduction_Erreur = 0;
$Production_succes = 0;
$Production_Warning = 0;
$Production_Erreur = 0;
$environnement = null;
$rapport = null;
$stat_recette = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$stat_preprod = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$stat_prod = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

foreach ($data as $value) {
    if ($value != '.' && $value != "..") {
// important
        $strdata = file_get_contents(__DIR__ . '/../data/project/'.$_SESSION['idProject'].'/livraison/' . $value);
        $strdata = json_decode($strdata, true);
        $environnement = $strdata['environnement'];
        // traitement de highcharts 2
        setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
        $date = explode('-', $value)[0];
        $mois = date('m', $date);


        $mois_lettre = strftime("%B.", $mois);
        for ($i = 0; $i <= 11; $i++) {

            if ($mois == ($i + 1) and $environnement == 'Recette') {
                $stat_recette[$i]++;
            }
        }
        for ($i = 1; $i <= 11; $i++) {
            if ($mois == ($i + 1) and $environnement == 'Preproduction') {
                $stat_preprod[$i]++;
            }
        }
        for ($i = 1; $i <= 11; $i++) {
            if ($mois == ($i + 1) and $environnement == 'Production') {
                $stat_prod[$i]++;
            }
        }

        //highcharts1

        if (isset($strdata['rapport'])) {
            $rapport = $strdata['rapport'];
        }

        if (($environnement == 'Recette') and (((isset($strdata['rapport'])) and ($strdata['rapport'] == "succes")) or !isset($strdata['rapport']))) {
            $Recette_succes++;
        }
        if ((isset($strdata['rapport'])) and ($environnement == 'Recette') and ($strdata['rapport'] == "Warning")) {
            $Recette_Warning++;
        }
        if ((isset($strdata['rapport'])) and ($environnement == 'Recette') and ($strdata['rapport'] == "Erreur")) {
            $Recette_Erreur++;
        }
        if (($environnement == 'Preproduction') and (((isset($strdata['rapport'])) and ($strdata['rapport'] == "succes")) or !isset($strdata['rapport']))) {

            $Preproduction_succes++;
        }
        if ((isset($strdata['rapport'])) and $environnement == 'Preproduction' and $strdata['rapport'] == "Warning") {
            $Preproduction_Warning++;
        }
        if ((isset($strdata['rapport'])) and $environnement == 'Preproduction' and $strdata['rapport'] == "Erreur") {
            $Preproduction_Erreur++;
        }
        if (($environnement == 'Production') and (((isset($strdata['rapport'])) and ($strdata['rapport'] == "succes")) or !isset($strdata['rapport']))) {

            $Production_succes++;
        }
        if ((isset($strdata['rapport'])) and $environnement == 'Production' and $strdata['rapport'] == "Warning") {
            $Production_Warning++;
        }
        if ((isset($strdata['rapport'])) and $environnement == 'Production' and $strdata['rapport'] == "Erreur") {
            $Production_Erreur++;
        }
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Highcharts Example</title>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <style type="text/css">
        ${demo.css}
    </style>

    <script type="text/javascript">

        $(function () {


            Highcharts.setOptions({
                colors: ['#C70039', '#FF5733', '#6FF406']
            });

            Highcharts.chart('container2', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Statistiques nombre des livraison par environnement / mois'
                },
                subtitle: {
                    text: 'Source: Historique des livraisons'
                },
                xAxis: {
                    categories: [
                        'janvier',
                        'février',
                        'mars',
                        'avril',
                        'mai',
                        'jun',
                        'juillet',
                        'aout',
                        'septembre',
                        'octobre',
                        'novembre',
                        'décembre'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Nombre'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Recette',
                    data: <?php echo(json_encode($stat_recette)); ?>

                }, {
                    name: 'Préproduction',
                    data: <?php echo(json_encode($stat_preprod)); ?>



                }, {
                    name: 'Production',
                    data: <?php echo(json_encode($stat_prod)); ?>



                }]
            });

        });

    </script>


    <script type="text/javascript">


        $(function () {


            Highcharts.setOptions({
                colors: ['#C70039', '#FF5733', '#6FF406']
            });


            Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'L historique des déploiements'
                },
                subtitle: {
                    text: 'Source: <a href="#">Historique</a>'
                },
                xAxis: {
                    categories: ['Recette', 'Préproduction', 'Production'],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'LIVRAISON',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' '
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                /* recette puis preprod  puis prod*/
                series: [{
                    name: ' Erreur',
                    data: [<?php print $Recette_Erreur?>, <?php print $Preproduction_Erreur?>, <?php print $Production_Erreur?>]
                }, {
                    name: 'Alerte',
                    data: [<?php print $Recette_Warning?>, <?php print $Preproduction_Warning?>, <?php print $Production_Warning?>]
                }, {
                    name: 'Succés',
                    data: [<?php print $Recette_succes?>, <?php print $Preproduction_succes?>, <?php print $Production_succes?>]

                }]


            });
        });

    </script>
</head>
<body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 1200px; height: 400px; margin: 0 auto"></div>

<div id="container2" style="min-width: 310px; max-width: 1200px; height: 600px; margin: 0 auto"></div>


</body>
</html>