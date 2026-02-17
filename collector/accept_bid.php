<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

$sneaker_id = $_POST['sneaker_id'] ?? null;
$bid_id = $_POST['bid_id'] ?? null;

if (!$sneaker_id || !$bid_id) {
    die("Ongeldige data.");
}