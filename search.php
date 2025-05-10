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

    $lots = [];
    $prepare_search_query = prepare_search_query('search');
    $query = get_lots_by_search($prepare_search_query);
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
        var_dump($lots);
    }
    $mainContent = include_template('templates/search.php', [
        'categories' => $categories,
        'search_query' => $prepare_search_query,
        'lots' => $lots,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'mainContent' => $mainContent,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Результаты поиска',
    ]);
    print($layout);
