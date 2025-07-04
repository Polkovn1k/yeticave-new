<?php
    $db_settings = [
        'host' => 'MySQL-8.4',
        'username' => 'root',
        'password' => '',
        'db_name' => 'yeticave_new',
        'port' => 3306,
    ];
    $mysqli = mysqli_connect($db_settings['host'], $db_settings['username'], $db_settings['password'], $db_settings['db_name'], $db_settings['port']);
    mysqli_set_charset($mysqli, 'utf8mb4');

    if (!$mysqli) {
        $error_message = mysqli_connect_error();
        /*TODO сделать вывод ошибки по нормальному шаблону*/
        die('Ошибка соединения: ' . $error_message);
    }

