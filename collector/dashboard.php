<?php
require_once "../includes/auth.php";
requireLogin();
?>

<h2>Collector Dashboard</h2>
<p>Welkom gebruiker ID: <?php echo $_SESSION['user_id']; ?></p>

<h3>Mijn Sneakers (My Closet)</h3>

<?php
$stmt = $pdo->prepare("SELECT * FROM sneakers WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$sneakers = $stmt->fetchAll();