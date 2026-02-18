<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $brand = $_POST["brand"];
    $size = $_POST["size"];
    $condition = $_POST["condition"];
    $image_url = $_POST["image_url"];

    $stmt = $pdo->prepare("INSERT INTO sneakers (user_id, brand, size, condition, image_url, status) VALUES (?, ?, ?, ?, ?, 'active')");
    $stmt->execute([$_SESSION["user_id"], $brand, $size, $condition, $image_url]);

    header("Location: dashboard.php");
    exit();
}
?>

<link rel="stylesheet" href="../Assets/style.css">

<div class="navbar">
    <div class="nav-left">
        <a href="dashboard.php">Dashboard</a>
        <a href="../public/marketplace.php">Marktplaats</a>
        <a href="add_sneaker.php">Sneaker toevoegen</a>
    </div>

    <div class="nav-right">
        <span><?php echo $_SESSION['email']; ?></span>
        <a href="../public/logout.php" style="color:white;">Uitloggen</a>
    </div>
</div>

<div class="container">

    <h2 style="margin-bottom:5px;">Sneaker Toevoegen</h2>
    <p style="color:#777; margin-bottom:30px;">
        Voeg een nieuwe sneaker toe aan jouw collectie.
    </p>

    <div class="card" style="max-width:500px;">

        <form method="POST">

            <label>Merk</label>
            <input type="text" name="brand" required>

            <label>Maat</label>
            <input type="number" name="size" step="0.5" required>

            <label>Conditie</label>
            <select name="condition" required>
                <option value="">Kies conditie</option>
                <option value="DS">DS</option>
                <option value="VNDS">VNDS</option>
                <option value="Used">Used</option>
            </select>

            <label>Afbeelding URL</label>
            <input type="text" name="image_url" required>

            <button type="submit" style="margin-top:15px;">
                Sneaker toevoegen
            </button>

        </form>

    </div>

</div>