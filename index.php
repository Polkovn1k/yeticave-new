<?php
require_once('data.php');
require_once('helpers.php');

$mainContent = include_template('templates/main.php', [
    'categories' => $categories,
    'products' => $products
]);
$layout = include_template('templates/layouts/master.php', [
    'mainContent' => $mainContent,
    'categories' => $categories,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'title' => 'Главная страница'
]);
print($layout);

