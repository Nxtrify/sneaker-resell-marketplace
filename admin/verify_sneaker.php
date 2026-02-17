<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();
requireAdmin();

$id = $_GET['id'] ?? null;
$decision = $_GET['decision'] ?? null;



if (!$id || !in_array($decision, ['approved', 'rejected'])) {
    die("Ongeldige actie.");
}


$stmt = $pdo->prepare("SELECT * FROM sneakers WHERE id = ?");
$stmt->execute([$id]);
$sneaker = $stmt->fetch();