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
    define('LOT_LIMIT', 9);
    define('PAGINATION_VISIBLE_LINKS', 3);
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
    $start_page = max(1, $page_number);
    $end_page = min($total_pages, $start_page + PAGINATION_VISIBLE_LINKS - 1);
    if (($end_page - $start_page + 1) < PAGINATION_VISIBLE_LINKS) {
        $start_page = max(1, $end_page - PAGINATION_VISIBLE_LINKS + 1);
    }

    $query = get_lots_by_search($prepare_search_query, LOT_LIMIT, $offset);
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    $mainContent = include_template('templates/search.php', [
        'categories' => $categories,
        'search_query' => $prepare_search_query,
        'lots' => $lots,
        'total_pages' => $total_pages,
        'page_number' => $page_number,
        'start_page' => $start_page,
        'end_page' => $end_page,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'mainContent' => $mainContent,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Результаты поиска',
    ]);
    print($layout);
