<?php
    function get_lots() {
        return "SELECT lots.id, lots.name AS name, start_price AS price, img, finish_time AS end_date, categories.name AS category FROM lots 
                INNER JOIN categories ON lots.category_id = categories.id
                WHERE finish_time > NOW() ORDER BY finish_time DESC;";
    }

    function get_lot($id) {
        return "SELECT lots.name AS lot_name, lots.created_at, lots.description, lots.img, lots.start_price, lots.finish_time AS end_date, lots.bet_step, categories.name AS category, categories.code FROM lots 
                INNER JOIN categories ON lots.category_id = categories.id 
                WHERE lots.id = $id;";
    }

    function get_category() {
        return 'SELECT * FROM categories;';
    }

    function get_last_added_lot() {
        return "SELECT * FROM lots ORDER BY id DESC LIMIT 1";
    }

    function add_new_lot() {
        return "INSERT INTO lots (name, description, img, start_price, finish_time, bet_step, user_id, winner_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }

    function get_email() {
        return "SELECT id, email, password, name FROM users WHERE users.email = ? LIMIT 1";
    }

    function set_new_user() {
        return "INSERT INTO users (email, name, password, contacts) VALUES (?, ?, ?, ?)";
    }

    function get_lots_count_by_search($search_query) {
        return "SELECT COUNT(*) AS total_count FROM lots 
                WHERE MATCH(name, description) AGAINST('$search_query');";
    }

    function get_lots_by_search($search_query, $limit, $offset) {
        return "SELECT lots.id, lots.created_at, lots.name, lots.description, lots.img, lots.start_price, lots.finish_time, lots.bet_step, categories.name AS category_name FROM lots 
                INNER JOIN categories ON lots.category_id = categories.id
                WHERE MATCH(lots.name, description) 
                AGAINST('$search_query') 
                ORDER BY created_at DESC LIMIT $limit OFFSET $offset;";
    }

    function get_lots_count_by_category($category_id) {
        return "SELECT COUNT(*) AS total_count FROM lots 
                INNER JOIN categories ON lots.category_id = categories.id
                WHERE lots.category_id = $category_id;";
    }

    function get_lots_by_category($category_id, $limit, $offset) {
        return "SELECT lots.id, lots.created_at, lots.name, lots.description, lots.img, lots.start_price, lots.finish_time, lots.bet_step, categories.name AS category_name FROM lots
                INNER JOIN categories ON lots.category_id = categories.id
                WHERE lots.category_id = $category_id
                ORDER BY created_at DESC LIMIT $limit OFFSET $offset;";
    }

    function get_lot_bets_count($lot_id) {
        return "SELECT COUNT(*) AS total_bets FROM bets WHERE bets.lot_id = $lot_id";
    }

    function get_lot_bets($lot_id) {
        return "SELECT DATE_FORMAT(bets.date, '%d.%m.%Y %H:%i') AS date, bets.price, users.id, users.name FROM bets 
                INNER JOIN users ON users.id = bets.user_id
                WHERE $lot_id = bets.lot_id
                ORDER BY bets.date DESC";
    }

    function add_new_bet() {
        return "INSERT INTO bets (price, user_id, lot_id) VALUES (?, ?, ?);";
    }

    function get_bets_by_user($user_id) {
        return "SELECT lots.name AS lot_name, lots.img, lots.finish_time, categories.name AS category_name, (SELECT MAX(bets.price) FROM bets WHERE lots.id = bets.lot_id) AS max_bets FROM lots 
                INNER JOIN categories ON lots.category_id = categories.id
                INNER JOIN bets ON lots.id = bets.lot_id
                WHERE bets.user_id = $user_id";
    }
