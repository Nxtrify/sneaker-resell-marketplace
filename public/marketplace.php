<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

$stmt = $pdo->prepare("SELECT s.*, 
    (SELECT MAX(amount) FROM bids WHERE sneaker_id = s.id) as highest_bid
    FROM sneakers s
    WHERE s.status='active' AND s.user_id != ?");
$stmt->execute([$_SESSION['user_id']]);
$sneakers = $stmt->fetchAll();
?>