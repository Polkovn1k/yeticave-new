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
    $category_type = isset($_GET['category_type']) ? trim($_GET['category_type']) : '';
    $is_right_category = check_is_right_category($categories, $category_type);
    if (!$is_right_category) {
        die('Выбранная категория не существует');
    }
    $index = array_search($category_type, array_column($categories, 'code'));
    $current_category = $categories[$index];

    $lots = [];
    define('LOT_LIMIT', 9);
    define('PAGINATION_VISIBLE_LINKS', 3);
    $page_number = get_page_number();
    $offset = ($page_number - 1) * LOT_LIMIT;

    $total_lots_count_query = get_lots_count_by_category($current_category['id']);
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

    $query = get_lots_by_category($current_category['id'], LOT_LIMIT, $offset);
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $categories_template = include_template('templates/layout_parts/category_part.php', [
        'categories' => $categories,
        'category_type' => $category_type,
    ]);
    $main_content = include_template('templates/category.php', [
        'categories' => $categories,
        'current_category' => $current_category,
        'lots' => $lots,
        'total_pages' => $total_pages,
        'page_number' => $page_number,
        'start_page' => $start_page,
        'end_page' => $end_page,
        'categories_template' => $categories_template,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Категория "' . $current_category['name'] . '"',
        'categories_template' => $categories_template,
    ]);
    print($layout);
