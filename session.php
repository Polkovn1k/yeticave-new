<?php
    session_start();
    $user_name = $_SESSION['name'] ?? null;
    $user_id = $_SESSION['id'] ?? null;
