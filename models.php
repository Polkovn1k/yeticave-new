<?php
    function get_lots() {
        return "SELECT lots.id, lots.name AS name, start_price AS price, img, finish_time AS end_date, categories.name AS category
                FROM lots INNER JOIN categories ON lots.category_id = categories.id
                WHERE finish_time > NOW() ORDER BY finish_time DESC;";
    }

    function get_lot($id) {
        return "SELECT lots.name AS lot_name, lots.created_at, lots.description, lots.img, lots.start_price, lots.finish_time AS end_date, lots.bet_step, categories.name AS category, categories.code 
                FROM lots INNER JOIN categories ON lots.category_id = categories.id 
                WHERE lots.id = $id;";
    }

    function get_category() {
        return 'SELECT * FROM categories;';
    }
