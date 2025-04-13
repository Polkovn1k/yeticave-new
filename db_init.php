<?php
    $db_settings = [
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db_name' => 'yeticave_new',
    ];
    $mysqli = mysqli_connect($db_settings['host'], $db_settings['username'], $db_settings['password'], $db_settings['db_name']);
    mysqli_set_charset($mysqli, 'utf8mb4');

