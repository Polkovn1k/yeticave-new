<?php
    require_once('session.php');
    require_once('models.php');
    require_once('helpers.php');
    require_once('db_init.php');

    $query = get_category();
    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        die('Ошибка соединения: ' . mysqli_error($mysqli));
    }
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $mainContent = include_template('templates/404.php', [
        'categories' => $categories,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'mainContent' => $mainContent,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Страница не найдена',
    ]);
    print($layout);
