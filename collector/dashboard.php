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

if ($sneakers):
    echo "<div style='display:grid; grid-template-columns:repeat(3,1fr); gap:20px;'>";
    foreach($sneakers as $s):
        echo "<div style='border:1px solid #ccc; padding:10px;'>
            <img src='{$s['image_url']}' width='150'><br>
            Merk: {$s['brand']}<br>
            Maat: {$s['size']}<br>
            Conditie: {$s['condition']}<br>
            Status: {$s['status']}
        </div>";
    endforeach;
    echo "</div>";
else:
    echo "<p>Geen sneakers toegevoegd.</p>";
endif;
?>

<p><a href="add_sneaker.php">Sneaker toevoegen</a></p>

<?php
if($s['status'] == 'active'){
    $stmt2 = $pdo->prepare("SELECT * FROM bids WHERE sneaker_id=? ORDER BY amount DESC LIMIT 1");
    $stmt2->execute([$s['id']]);
    $highest_bid = $stmt2->fetch();


