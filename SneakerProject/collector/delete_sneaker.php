<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

$id = $_POST['sneaker_id'] ?? null;

if (!$id) {
    die("Ongeldige aanvraag.");
}

// Check of sneaker van ingelogde gebruiker is
$stmt = $pdo->prepare("SELECT * FROM sneakers WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$sneaker = $stmt->fetch();

if (!$sneaker) {
    die("Sneaker niet gevonden of niet van jou.");
}


if ($sneaker['status'] !== 'active') {
    die("Sneaker kan niet verwijderd worden.");
}


$pdo->prepare("DELETE FROM sneakers WHERE id = ?")->execute([$id]);

header("Location: dashboard.php");
exit();