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

    $errors = [];
    $prepared_log_data = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required_fields = [
            'email' => 'Email',
            'password' => 'Пароль',
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
            }
        }

        foreach ($_POST as $key => $value) {
            if (empty($errors[$key])) {
                $prepared_log_data[$key] = $value;
            }
        }

        if (count($errors) === 0) {
            $user = get_user_by_mail($mysqli);
            if (!empty($user)) {
                $is_email_existing = $_POST['email'] === $user['email'];
                $is_right_password = password_verify($_POST['password'], $user['password']);
                if ($is_email_existing && $is_right_password) {
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['id'] = $user['id'];
                    header('Location: /');
                    die();
                }
            }
            $errors['email'][] = "Не найден пользователь с таким email или введен неверный пароль";
        }
    }

    $mainContent = include_template('templates/login.php', [
        'categories' => $categories,
        'errors' => $errors,
    ]);
    $layout = include_template('templates/layouts/master.php', [
        'mainContent' => $mainContent,
        'categories' => $categories,
        'user_name' => $user_name,
        'title' => 'Вход на сайт'
    ]);
    print($layout);

