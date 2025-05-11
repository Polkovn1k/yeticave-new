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
    define('LOT_LIMIT', 3);
    $page_number = get_page_number();
    $prepare_search_query = prepare_search_query('search');
    $offset = ($page_number - 1) * LOT_LIMIT;

    $total_lots_count_query = get_lots_count_by_search($prepare_search_query);
    $result = mysqli_query($mysqli, $total_lots_count_query);
    if (!$result) {
        die('Ошибка получения лотов');
    }
    $total_lots_row_count = $result->fetch_assoc();
    $total_pages = ceil((int)$total_lots_row_count['total_count'] / LOT_LIMIT);
    $total_pages_array = range(1, $total_pages);
    var_dump($total_pages_array);

    $query = get_lots_by_search($prepare_search_query, LOT_LIMIT, $offset);
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
        var_dump($lots);
    }
    $mainContent = include_template('templates/search.php', [
        'categories' => $categories,
        'search_query' => $prepare_search_query,
        'lots' => $lots,
        'total_pages_array' => $total_pages_array,
        'total_pages' => $total_pages,
        'page_number' => $page_number,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'mainContent' => $mainContent,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Результаты поиска',
    ]);
    print($layout);
