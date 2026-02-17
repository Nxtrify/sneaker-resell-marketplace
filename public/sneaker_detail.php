<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

$id = $_GET['id'] ?? null;
if (!$id) die("Sneaker ID ontbreekt.");

$stmt = $pdo->prepare("SELECT s.*, (SELECT MAX(amount) FROM bids WHERE sneaker_id=s.id) as highest_bid FROM sneakers s WHERE id=?");
$stmt->execute([$id]);
$sneaker = $stmt->fetch();
if (!$sneaker) die("Sneaker niet gevonden.");
