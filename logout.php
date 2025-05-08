<?php
    session_start();
    require_once('helpers.php');
    unset($_SESSION['name']);
    unset($_SESSION['id']);
    session_unset();
    session_destroy();
    remove_session_cookie();
    header('Location: /');
    die();



