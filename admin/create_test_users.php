<?php
require_once "config/database.php"; 

$adminEmail = "admin@test.nl";
$adminPassword = password_hash("admin123", PASSWORD_BCRYPT);
$adminRole = "admin";
$adminBlocked = 0;

$collectorEmail = "collector@test.nl";
$collectorPassword = password_hash("collector123", PASSWORD_BCRYPT);
$collectorRole = "collector";
$collectorBlocked = 0;


$stmt = $pdo->prepare("INSERT INTO users (email, password, role, blocked) VALUES (?, ?, ?, ?)");
$stmt->execute([$adminEmail, $adminPassword, $adminRole, $adminBlocked]);


$stmt = $pdo->prepare("INSERT INTO users (email, password, role, blocked) VALUES (?, ?, ?, ?)");
$stmt->execute([$collectorEmail, $collectorPassword, $collectorRole, $collectorBlocked]);

echo "Testaccounts aangemaakt!";