<?php
session_start();
$user_name = $_SESSION['name'] ?? null;
