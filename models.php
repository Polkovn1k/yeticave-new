<?php
    function get_lots() {
        return "SELECT lots.name AS name, start_price AS price, img, finish_time AS end_date, categories.name AS category
                FROM lots INNER JOIN categories ON lots.category_id = categories.id
                WHERE finish_time > NOW() ORDER BY finish_time DESC";
    }

    function get_category() {
        return 'SELECT * FROM categories;';
    }
