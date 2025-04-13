<?php
    require_once('data.php');
    require_once('helpers.php');
    require_once('db_init.php');
    require_once('models.php');

    if (!$mysqli) {
        $error_message = mysqli_connect_error();
        /*TODO сделать вывод ошибки по нормальному шаблону*/
        die('Ошибка соединения: ' . $error_message);
    }

    $query = get_lots();
    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        die('Ошибка соединения: ' . mysqli_error($mysqli));
    }
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query = get_category();
    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        die('Ошибка соединения: ' . mysqli_error($mysqli));
    }
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $mainContent = include_template('templates/main.php', [
        'categories' => $categories,
        'lots' => $lots
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'mainContent' => $mainContent,
        'categories' => $categories,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'title' => 'Главная страница'
    ]);
    print($layout);

