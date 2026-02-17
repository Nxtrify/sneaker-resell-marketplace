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

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);
    $highest = $sneaker['highest_bid'] ?? 0;

    if ($amount <= $highest) {
        $error = "Bod moet hoger zijn dan huidige hoogste bod (€$highest).";
    } else {
        $stmt = $pdo->prepare("INSERT INTO bids (sneaker_id, user_id, amount) VALUES (?, ?, ?)");
        $stmt->execute([$sneaker['id'], $_SESSION['user_id'], $amount]);
        $success = "Bod geplaatst!";
        $sneaker['highest_bid'] = $amount;
    }
}
?>

