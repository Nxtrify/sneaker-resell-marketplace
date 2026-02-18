<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

$id = $_GET['id'] ?? null;

if (!$id) {
    $error_message = "Sneaker ID ontbreekt.";
} else {

    $stmt = $pdo->prepare("
        SELECT s.*, 
        (SELECT MAX(amount) FROM bids WHERE sneaker_id = s.id) as highest_bid 
        FROM sneakers s 
        WHERE id = ?
    ");
    $stmt->execute([$id]);
    $sneaker = $stmt->fetch();

    if (!$sneaker) {
        $error_message = "Sneaker niet gevonden.";
    } 
    elseif ($sneaker['user_id'] == $_SESSION['user_id']) {
        $error_message = "Je kan niet bieden op je eigen sneaker.";
    } 
    elseif ($sneaker['status'] !== 'active') {
        $error_message = "Je kan niet bieden op deze sneaker.";
    }
}

$error = "";
$success = "";

/* 
   ERROR PAGE 
 */
if (isset($error_message)) {
?>
<link rel="stylesheet" href="../Assets/style.css">

<div class="navbar">
    <div class="nav-left">
        <a href="../collector/dashboard.php">Dashboard</a>
        <a href="marketplace.php">Marktplaats</a>
    </div>

    <div class="nav-right">
        <span><?php echo $_SESSION['email']; ?></span>
        <a href="logout.php" style="color:white;">Uitloggen</a>
    </div>
</div>

<div class="container">
    <div class="card" style="max-width:500px; margin:auto; text-align:center;">
        <h2 style="color:#f44336;">Actie niet toegestaan</h2>
        <p style="margin:20px 0;">
            <?php echo $error_message; ?>
        </p>

        <a href="../collector/dashboard.php">
            <button>Terug naar dashboard</button>
        </a>
    </div>
</div>

<?php
exit();
}
/* 
   EINDE ERROR PAGE
 */


/* 
   BIEDING VERWERKEN
 */
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

<link rel="stylesheet" href="../Assets/style.css">

<div class="navbar">
    <div class="nav-left">
        <a href="../collector/dashboard.php">Dashboard</a>
        <a href="marketplace.php">Marktplaats</a>
    </div>

    <div class="nav-right">
        <span><?php echo $_SESSION['email']; ?></span>
        <a href="logout.php" style="color:white;">Uitloggen</a>
    </div>
</div>

<div class="container">

    <div class="card" style="display:flex; gap:30px; flex-wrap:wrap;">

        <div style="flex:1;">
            <img src="<?php echo $sneaker['image_url']; ?>" 
                 style="width:100%; border-radius:10px;">

            <h2 style="margin-top:15px;"><?php echo $sneaker['brand']; ?></h2>

            <p>Maat: <?php echo $sneaker['size']; ?></p>
            <p>Conditie: <?php echo $sneaker['condition']; ?></p>

            <p>
                Status:
                <span class="badge <?php echo $sneaker['status']; ?>">
                    <?php echo $sneaker['status']; ?>
                </span>
            </p>
        </div>

        <div style="flex:1;">

            <h3>
                Hoogste bod: 
                <?php echo $sneaker['highest_bid'] ? "€".$sneaker['highest_bid'] : "Nog geen bod"; ?>
            </h3>

            <?php if ($error): ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p style="color:green;"><?php echo $success; ?></p>
            <?php endif; ?>

            <form method="POST" style="margin-top:20px;">
                <input type="number" 
                       step="0.01" 
                       name="amount" 
                       placeholder="Voer je bod in (€)" 
                       required>

                <button type="submit" style="margin-top:10px;">
                    Plaats bod
                </button>
            </form>

        </div>

    </div>

</div>
