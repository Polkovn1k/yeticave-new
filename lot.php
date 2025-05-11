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

    $categories_template = include_template('templates/layout_parts/category_part.php', [
        'categories' => $categories,
    ]);
    $main_content = include_template('templates/404.php', [
        'categories' => $categories,
        'categories_template' => $categories_template,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Страница не найдена',
        'categories_template' => $categories_template,
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

    $main_content = include_template('templates/lot-detail.php', [
        'categories' => $categories,
        'categories_template' => $categories_template,
        'lot' => $lot,
        'user_name' => $user_name,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => $lot['lot_name'],
        'categories_template' => $categories_template,
    ]);
    print($layout);
