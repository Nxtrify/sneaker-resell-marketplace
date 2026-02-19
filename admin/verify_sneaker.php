<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

requireLogin();  // Alleen ingelogde gebruikers
requireAdmin();  // Alleen admin mag verifiëren

$id = $_GET['id'] ?? null;
$decision = $_GET['decision'] ?? null;

// Controleer of ID bestaat en decision geldig is
if (!$id || !in_array($decision, ['approved', 'rejected'])) {
    die("Ongeldige actie.");
}

// Controleer of sneaker bestaat
$stmt = $pdo->prepare("SELECT * FROM sneakers WHERE id = ?");
$stmt->execute([$id]);
$sneaker = $stmt->fetch();

if (!$sneaker) {
    die("Sneaker niet gevonden.");
}

// Update status op basis van beslissing
if ($decision === 'approved') {
    $stmt = $pdo->prepare("UPDATE sneakers SET status = 'sold' WHERE id = ?");
    $stmt->execute([$id]);
} else {
    $stmt = $pdo->prepare("UPDATE sneakers SET status = 'active' WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: dashboard.php"); // Terug naar admin dashboard
exit();
