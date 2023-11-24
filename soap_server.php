<?php
require_once('config.inc.php');

// Adatbázis kapcsolódás
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// SOAP szolgáltatás létrehozása
class SweetOvenService {
    public function getSutemenyek() {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM suti");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTartalom($sutiId) {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM tartalom WHERE sutiid = $sutiId");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAr($sutiId) {
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM ar WHERE sutiid = $sutiId");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

// SOAP szerver létrehozása
$server = new SoapServer(null, array('uri' => 'http://localhost/soap_server.php'));
$server->setClass('SweetOvenService');
$server->handle();
?>
