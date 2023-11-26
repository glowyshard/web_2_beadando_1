<?php require_once('config.inc.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - The Sweet Oven</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require_once("header.php")?>

    <div class="container d-flex align-items-center flex-column content-container">
        <h2>Sütemények</h2>
        <?php
        // SOAP client
        $client = new SoapClient(null, array(
            'location' => 'http://localhost/soap_server.php',
            'uri'      => 'http://localhost/soap_server.php',
        ));

        // Get sütemények
        $sutemenyek = $client->getSutemenyek();

        // Display sütemények
        echo '<ul>';
        foreach ($sutemenyek as $suti) {
            echo '<li>';
            echo 'Név: ' . $suti['nev'] . ', ';
            echo 'Típus: ' . $suti['tipus'] . ', ';
            echo 'Díjazott: ' . ($suti['dijazott'] ? 'Igen' : 'Nem');
            echo '</li>';
        }
        echo '</ul>';
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>