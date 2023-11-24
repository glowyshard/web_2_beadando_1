<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cuk_db');
$menu = array(
    array('text' => 'Home', 'link' => '/web_2_beadando_1-main/index.php'),
    array('text' => 'SütiMenü', 'link' => '/web_2_beadando_1-main/menu.php'),
    array('text' => 'MNB Menü', 'link' => '/web_2_beadando_1-main/magyarb.php'),
);

if (session_status() == PHP_SESSION_NONE) {
    
    session_start();
}

$loggedInUser = "";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $loggedInUser = "Logged in: " . $_SESSION['family_name'] . " " . $_SESSION['surname'] . " (" . $_SESSION['login_name'] . ")";
}


if ($loggedInUser !== "") {
    $menu[] = array('text' => 'Véleményezés', 'link' => '/web_2_beadando_1-main/opinions.php');
}

?>
