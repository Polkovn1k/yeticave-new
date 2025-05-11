<?php
    require_once('session.php');
    require_once('models.php');
    require_once('helpers.php');
    require_once('db_init.php');

    $query = get_lots();
    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        die('Ошибка соединения: ' . mysqli_error($mysqli));
    }
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query = get_category();
    $result = mysqli_query($mysqli, $query);
    if (!$result) {
        die('Ошибка соединения: ' . mysqli_error($mysqli));
    }
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($user_name) {
        $categories_template = include_template('templates/layout_parts/category_part.php', [
            'categories' => $categories,
        ]);
        $main_content = include_template('templates/403.php', [
            'categories' => $categories,
            'categories_template' => $categories_template,
            'add_text_content' => "<h2>У вас уже зарегистрирован аккаунт: $user_name</h2>",
        ]);
        $layout = include_template('templates/layouts/master.php', [
            'main_content' => $main_content,
            'categories' => $categories,
            'user_name' => $user_name,
            'title' => 'В доступе отказано',
            'categories_template' => $categories_template,
        ]);
        http_response_code(403);
        print($layout);
        die();
    }

    $errors = [];
    $prepared_reg_data = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required_fields = [
            'email' => 'Email',
            'password' => 'Пароль',
            'name' => 'Имя',
            'contacts' => 'Контакты',
        ];

        foreach ($required_fields as $key => $value) {
            if (!isset($_POST[$key])) {
                $errors[$key][] = "Поле '$value' не существует в форме";
                continue;
            }
            if (is_field_empty($_POST[$key])) {
                $errors[$key][] = "Поле '$value' не должно быть пустым";
            }
            if (($key === 'email')) {
                if (!(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL))) {
                    $errors[$key][] = "Поле '$value' должно быть корректным email";
                }
                $existiting_user = is_existing_email($mysqli);
                if ($existiting_user) {
                    $errors[$key][] = "Пользователь с указанным '$value' уже существует";
                }
            }
            if (($key === 'password') && !(preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{12}$/', $_POST[$key]))) {
                $errors[$key][] = "Поле '$value' должно содержать 12 латинских символов/цифр";
            }
        }

        foreach ($_POST as $key => $value) {
            if (empty($errors[$key])) {
                $prepared_reg_data[$key] = $value;
            }
        }

        if (count($errors) === 0) {
            $stmt = mysqli_prepare($mysqli, set_new_user());
            $pass_hash = password_hash($prepared_reg_data['password'], PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, 'ssss', $prepared_reg_data['email'], $prepared_reg_data['name'], $pass_hash, $prepared_reg_data['contacts']);
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    header('Location: /login.php');
                    die();
                } else {
                    die('Ошибка добавления нового пользователя!');
                }
            } else {
                die('Ошибка добавления нового пользователя: ' . mysqli_stmt_error($stmt));
            }
        }
    }

    $categories_template = include_template('templates/layout_parts/category_part.php', [
        'categories' => $categories,
    ]);
    $main_content = include_template('templates/sign-up.php', [
        'categories' => $categories,
        'errors' => $errors,
        'reg_data' => $prepared_reg_data,
        'categories_template' => $categories_template,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Регистрация аккаунта',
        'categories_template' => $categories_template,
    ]);
    print($layout);

