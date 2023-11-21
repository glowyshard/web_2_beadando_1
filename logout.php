<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: /web_2_beadando_1-main/fiok.php");
    exit();
?>
