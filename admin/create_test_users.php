<?php
require_once "config/database.php"; // Zorg dat $pdo beschikbaar is

$adminEmail = "admin@test.nl";
$adminPassword = password_hash("admin123", PASSWORD_BCRYPT);
$adminRole = "admin";
$adminBlocked = 0;

$collectorEmail = "collector@test.nl";
$collectorPassword = password_hash("collector123", PASSWORD_BCRYPT);
$collectorRole = "collector";
$collectorBlocked = 0;