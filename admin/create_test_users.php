<?php
require_once "config/database.php"; // Zorg dat $pdo beschikbaar is

$adminEmail = "admin@test.nl";
$adminPassword = password_hash("admin123", PASSWORD_BCRYPT);
$adminRole = "admin";
$adminBlocked = 0;
