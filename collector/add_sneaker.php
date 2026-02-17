<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $brand = $_POST["brand"];
    $size = $_POST["size"];
    $condition = $_POST["condition"];
    $image_url = $_POST["image_url"];