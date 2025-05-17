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

    $bets = [];
    $bets_count = 0;
    $query = get_lot_bets_count($lot_id);
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $bets_count = $result->fetch_assoc()['total_bets'];
    }
    $query = get_lot_bets($lot_id);
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required_fields = [
            'cost' => 'Ставка',
        ];

        foreach ($required_fields as $key => $value) {
            if (!isset($_POST[$key])) {
                $errors[] = "Поле '$value' не существует в форме";
                continue;
            }
            if (is_field_empty($_POST[$key])) {
                $errors[] = "Поле '$value' не должно быть пустым";
                continue;
            }
            if (($key === 'cost')) {
                if (!(filter_var($_POST[$key], FILTER_VALIDATE_INT))) {
                    $errors[] = "Поле '$value' должно быть целым числом";
                    continue;
                }
                if ($_POST[$key] < $lot['bet_step']) {
                    $errors[] = "Поле '$value' должно быть не ниже ". $lot['bet_step'];
                }
            }
        }

        if (count($errors) === 0) {
            $stmt = mysqli_prepare($mysqli, add_new_bet());
            mysqli_stmt_bind_param($stmt, 'iii', $_POST['cost'], $user_id, $lot_id);
            if (!mysqli_stmt_execute($stmt)) {
                die('Ошибка добавления ставки');
            } else {
                header('Location: '. $_SERVER['REQUEST_URI']);
            }
        }
    }

    $main_content = include_template('templates/lot-detail.php', [
        'categories' => $categories,
        'categories_template' => $categories_template,
        'lot' => $lot,
        'user_name' => $user_name,
        'bets_count' => $bets_count,
        'bets' => $bets,
        'errors' => $errors,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => $lot['lot_name'],
        'categories_template' => $categories_template,
    ]);
    print($layout);
