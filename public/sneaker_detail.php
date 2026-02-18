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


if ($sneaker['user_id'] == $_SESSION['user_id']) {
    $error_message = "Je kan niet bieden op je eigen sneaker.";
}


if ($sneaker['status'] !== 'active') {
    $error_message = "Je kan niet bieden op deze sneaker.";
}



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

<h2>Sneaker Detail</h2>

<div style="display:flex; gap:20px;">
    <div>
        <img src="<?php echo $sneaker['image_url']; ?>" width="200"><br>
        Merk: <?php echo $sneaker['brand']; ?><br>
        Maat: <?php echo $sneaker['size']; ?><br>
        Conditie: <?php echo $sneaker['condition']; ?><br>
        Status: <?php echo $sneaker['status']; ?><br>
    </div>
    <div>
        <h3>Hoogste bod: <?php echo $sneaker['highest_bid'] ? "€".$sneaker['highest_bid'] : "Nog geen bod"; ?></h3>

         <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

        <form method="POST">
            Bod plaatsen (€): <input type="number" step="0.01" name="amount" required><br>
            <button type="submit">Bied</button>
        </form>
    </div>
</div>

<p><a href="marketplace.php">Terug naar Marktplaats</a></p>
