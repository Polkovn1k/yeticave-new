<?php
    $db_settings = [
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db_name' => 'yeticave_new',
    ];
    $mysqli = mysqli_connect($db_settings['host'], $db_settings['username'], $db_settings['password'], $db_settings['db_name']);
    mysqli_set_charset($mysqli, 'utf8mb4');

    if (!$mysqli) {
        $error_message = mysqli_connect_error();
        /*TODO сделать вывод ошибки по нормальному шаблону*/
        die('Ошибка соединения: ' . $error_message);
    }

