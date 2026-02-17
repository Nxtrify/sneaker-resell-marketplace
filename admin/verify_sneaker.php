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

if (!$sneaker) {
    die("Sneaker niet gevonden.");
}

// Update status
if ($decision === 'approved') {
    $stmt = $pdo->prepare("UPDATE sneakers SET status = 'sold' WHERE id = ?");
    $stmt->execute([$id]);
} else {
    $stmt = $pdo->prepare("UPDATE sneakers SET status = 'active' WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: dashboard.php");
exit();