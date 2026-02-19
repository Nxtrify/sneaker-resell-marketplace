<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

requireLogin(); 

$sneaker_id = $_POST['sneaker_id'] ?? null;
$bid_id = $_POST['bid_id'] ?? null;

// Controleer of benodigde data aanwezig is
if (!$sneaker_id || !$bid_id) die("Ongeldige data");

// Controleer of sneaker van ingelogde gebruiker is (ownership check)
$stmt = $pdo->prepare("SELECT * FROM sneakers WHERE id=? AND user_id=?");
$stmt->execute([$sneaker_id, $_SESSION['user_id']]);
$sneaker = $stmt->fetch();

if (!$sneaker) die("Niet jouw sneaker.");

// Zet status op verification zodat admin deze kan controleren
$pdo->prepare("UPDATE sneakers SET status='verification' WHERE id=?")
    ->execute([$sneaker_id]);

header("Location: dashboard.php"); 
exit();