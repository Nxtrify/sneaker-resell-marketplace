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

      if (!$brand || !$size || !$condition) {
        $error = "Vul alle verplichte velden in.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO sneakers (user_id, brand, size, `condition`, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $brand, $size, $condition, $image_url]);
        $success = "Sneaker toegevoegd!";
    }
}
?>