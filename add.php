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

    if (!$user_name) {
        $categories_template = include_template('templates/layout_parts/category_part.php', [
            'categories' => $categories,
        ]);
        $main_content = include_template('templates/403.php', [
            'categories' => $categories,
            'categories_template' => $categories_template,
        ]);
        $layout = include_template('templates/layouts/master.php', [
            'main_content' => $main_content,
            'categories' => $categories,
            'title' => 'В доступе отказано',
            'categories_template' => $categories_template,
        ]);
        http_response_code(403);
        print($layout);
        die();
    }

    $errors = [];
    $prepared_lot = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required_fields = [
            'lot_name' => 'Наименование',
            'category' => 'Категория',
            'lot_description' => 'Описание',
            'lot_rate' => 'Начальная цена',
            'lot_step' => 'Шаг ставки',
            'lot_date' => 'Дата окончания торгов',
        ];

        foreach ($required_fields as $key => $value) {
            if (!isset($_POST[$key])) {
                $errors[$key][] = "Поле '$value' не существует в форме";
                continue;
            }
            if (is_field_empty($_POST[$key])) {
                $errors[$key][] = "Поле '$value' не должно быть пустым";
            }
            if (($key === 'lot_rate' || $key === 'lot_step') && !(ctype_digit($_POST[$key]) && (int)$_POST[$key] > 0)) {
                $errors[$key][] = "Поле '$value' должно быть целым числом больше нуля";
            }
            if ($key === 'lot_date' && is_incorrect_date_format($_POST[$key])) {
                $errors[$key][] = "Неверный формат даты. Ожидается ГГГГ-ММ-ДД";
            }
        }

        $img_errors = img_load_errors($_FILES['lot_img']);
        if (count($img_errors) > 0) {
            $errors['lot_img'] = $img_errors;
        }
        foreach ($_POST as $key => $value) {
            if (empty($errors[$key])) {
                $prepared_lot[$key] = $value;
            }
        }

        if (count($errors) === 0) {
            $original_img_name = $_FILES['lot_img']['name'];
            $img_ext = pathinfo($original_img_name, PATHINFO_EXTENSION);
            $new_img_name = uniqid('lot-').".$img_ext";
            $new_img_path = __DIR__.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$new_img_name;
            $is_img_moved = move_uploaded_file($_FILES['lot_img']['tmp_name'], $new_img_path);
            if ($is_img_moved) {
                $user_id = $user_id;
                $winner_id = null;
                $stmt = mysqli_prepare($mysqli, add_new_lot());
                mysqli_stmt_bind_param($stmt, 'sssisiisi', $prepared_lot['lot_name'], $prepared_lot['lot_description'], $new_img_name, $prepared_lot['lot_rate'], $prepared_lot['lot_date'], $prepared_lot['lot_step'], $user_id, $winner_id, $prepared_lot['category']);
                if (mysqli_stmt_execute($stmt)) {
                    $new_id = mysqli_insert_id($mysqli);
                    header("Location: /lot.php?id=$new_id");
                }
            }
        }
    }

    $categories_template = include_template('templates/layout_parts/category_part.php', [
        'categories' => $categories,
    ]);
    $main_content = include_template('templates/add.php', [
        'categories' => $categories,
        'errors' => $errors,
        'lot' => $prepared_lot,
        'categories_template' => $categories_template,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Добавление лота',
        'categories_template' => $categories_template,
    ]);
    print($layout);
