<?php
    require_once('vendor/autoload.php');
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

    $my_bets = [];
    $query = get_bets_by_user($user_id);
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $my_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $categories_template = include_template('templates/layout_parts/category_part.php', [
        'categories' => $categories,
    ]);
    $main_content = include_template('templates/my-bets.php', [
        'categories' => $categories,
        'categories_template' => $categories_template,
        'my_bets' => $my_bets,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Мои ставки',
        'categories_template' => $categories_template,
    ]);
    print($layout);
