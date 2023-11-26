<?php require_once('config.inc.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNB-Menü - The Sweet Oven</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php require_once("header.php")?>

    <div class="container d-flex align-items-center flex-column content-container">
        <?php
        // WSDL fájl URL-je a Magyar Nemzeti Bank SOAP szolgáltatásához
        $wsdlUrl = 'https://www.mnb.hu/arfolyamok.asmx?wsdl';

        try {
            // SOAP kliens létrehozása
            $client = new SoapClient($wsdlUrl, array('cache_wsdl' => WSDL_CACHE_NONE));

            // a, Egy adott devizapár adott napján az árfolyam lekérdezése
            $currencyPair = 'EURHUF';
            $date = '2023-11-01';
            $resultA = $client->GetExchangeRates($date, $currencyPair);

            // b, Egy adott devizapár egy adott hónapjában az árfolyamok lekérdezése
            $currencyPairB = 'USDHUF';
            $monthB = '2023-11';
            $resultB = $client->GetExchangeRatesByMonth($monthB, $currencyPairB);

            // Eredmények megjelenítése
            echo '<h2>a, Egy adott devizapár adott napján az árfolyam:</h2>';
            echo 'Devizapár: ' . $resultA->deviza . '<br>';
            echo 'Dátum: ' . $resultA->datum . '<br>';
            echo 'Árfolyam: ' . $resultA->arfolyam . '<br>';

            echo '<h2>b, Egy adott devizapár egy adott hónapjában az árfolyamok:</h2>';
            foreach ($resultB->item as $item) {
                echo 'Dátum: ' . $item->datum . ', Árfolyam: ' . $item->arfolyam . '<br>';
            }

            // Chart.js használata a grafikon elkészítéséhez
            echo '<canvas id="myChart" width="400" height="200"></canvas>';
            echo '<script>
                var ctx = document.getElementById("myChart").getContext("2d");
                var myChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        datasets: [{
                            label: "' . $currencyPairB . ' árfolyamai",
                            data: ' . json_encode($resultB->item) . ',
                            borderColor: "rgb(75, 192, 192)",
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: "time",
                                time: {
                                    unit: "day"
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>';
        } catch (SoapFault $e) {
            echo 'SOAP hiba: ' . $e->getMessage();
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
