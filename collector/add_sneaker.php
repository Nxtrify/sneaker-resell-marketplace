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

<h2>Voeg Sneaker Toe</h2>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    Merk: <input type="text" name="brand" required><br>
    Maat: <input type="text" name="size" required><br>
    Conditie: 
    <select name="condition" required>
        <option value="">Kies</option>
        <option value="DS">DS</option>
        <option value="VNDS">VNDS</option>
        <option value="Used">Used</option>
    </select><br>
    Afbeelding URL: <input type="text" name="image_url"><br>
    <button type="submit">Toevoegen</button>
</form>

<p><a href="dashboard.php">Terug naar dashboard</a></p>