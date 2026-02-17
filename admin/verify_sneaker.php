<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();
requireAdmin();

$id = $_GET['id'] ?? null;
$decision = $_GET['decision'] ?? null;