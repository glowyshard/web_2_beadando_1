<?php

$menu = array(
    array('text' => 'Home', 'link' => '/web_2_beadando_1-main/index.php'),
);

if (session_status() == PHP_SESSION_NONE) {
    // Only start the session if it's not started already
    session_start();
}

$loggedInUser = "";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $loggedInUser = "Logged in: " . $_SESSION['family_name'] . " " . $_SESSION['surname'] . " (" . $_SESSION['login_name'] . ")";
}

// Add the "Véleményezés" link only for logged-in users
if ($loggedInUser !== "") {
    $menu[] = array('text' => 'Véleményezés', 'link' => '/web_2_beadando_1-main/opinions.php');
}

?>
