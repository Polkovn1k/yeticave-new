<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * @param float $number Принимаем цену лота, в т.ч. не целое число
 * @return string Выводим строку - цена + символ ₽
 */
function price_format(float $number, bool $need_currency = false): string {
    $integer = ceil($number);
    $value = number_format($integer, 0, '', ' ');
    return $value. ($need_currency ? ' ₽' : '');
}

/**
 * @param string $date Принимаем строку даты в виде YYY-mm-dd
 * @return array Возвращаем массив из 2-х чисел: 1-е это оставшиеся часы, 2-е оставшиеся минуты
 */
function get_time_left(string $date): array {
    $current_date = new DateTime('now');
    $value_date = new DateTime($date);
    $diff = date_diff($current_date, $value_date);
    if ($diff->invert) {
        return ['00', '00'];
    }
    $total_hours = $diff->days * 24 + $diff->h;
    return [str_pad($total_hours, 2, '0', STR_PAD_LEFT), str_pad($diff->i, 2, '0', STR_PAD_LEFT)];
}

function is_field_empty(string $data): bool {
    if (mb_strlen($data) === 0) {
        return true;
    }
    return false;
}

function is_incorrect_date_format(string $dateInput): bool {
    $format = 'Y-m-d';
    $date = DateTime::createFromFormat($format, $dateInput);
    if ($date && $date->format($format) === $dateInput) {
        $minDate = new DateTime();
        $minDate->modify('+1 day');

        if ($date >= $minDate) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function img_load_errors(array $file): array {
    $errors = [];
    if (!is_uploaded_file($file['tmp_name']) || $file['error'] !== 0) {
        $errors[] = "Картинка не загружена";
        return $errors;
    }
    if (!is_right_img_mime($file)) {
        $errors[] = "Недопустимый тип файла. Загружать можно *.jpeg/jpg/png";
    }
    define('MAX_IMG_SIZE', 3145728);
    if ($file['size'] > MAX_IMG_SIZE) {
        $errors[] = "Недопустимый размер файла. Ограничение - 3mb";
    }
    return $errors;
}

function is_right_img_mime(array $file): bool {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $loaded_img_mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    define('MIME_TYPES', ['image/png', 'image/jpeg']);
    $result = array_filter(MIME_TYPES, function($mime) use($loaded_img_mime_type) {
        return $mime === $loaded_img_mime_type;
    });
    return (count($result) > 0);
}

function is_existing_email($mysqli): bool {
    $email = $_POST['email'];
    $stmt = mysqli_prepare($mysqli, get_email());
    mysqli_stmt_bind_param($stmt, 's', $email);
    if (mysqli_stmt_execute($stmt)) {
        $data = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($data);
        return $result && count($result) > 0;
    }
    return false;
}
