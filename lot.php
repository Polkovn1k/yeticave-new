<?php
    require_once('data.php');
    require_once('helpers.php');
    require_once('db_init.php');
    require_once('models.php');

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
        'is_auth' => $is_auth,
        'title' => 'Страница не найдена',
    ]);

    $lot_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$lot_id) {
        print($layout);
    }

    $query = get_lot($lot_id);
    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        print($layout);
    }
    if (mysqli_num_rows($result) === 0) {
        print($layout);
    }
    $lot = mysqli_fetch_assoc($result);

    $mainContent = include_template('templates/lot-detail.php', [
        'categories' => $categories,
        'lot' => $lot,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'mainContent' => $mainContent,
        'categories' => $categories,
        'user_name' => $user_name,
        'is_auth' => $is_auth,
        'title' => $lot['lot_name'],
    ]);
    print($layout);
