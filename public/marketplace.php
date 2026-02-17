<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

$stmt = $pdo->prepare("SELECT s.*, 
    (SELECT MAX(amount) FROM bids WHERE sneaker_id = s.id) as highest_bid
    FROM sneakers s
    WHERE s.status='active' AND s.user_id != ?");
$stmt->execute([$_SESSION['user_id']]);
$sneakers = $stmt->fetchAll();
?>

<h2>Marktplaats</h2>

<?php
if ($sneakers):
    echo "<div style='display:grid; grid-template-columns:repeat(3,1fr); gap:20px;'>";
    foreach($sneakers as $s):
        $bid = $s['highest_bid'] ? "€".$s['highest_bid'] : "Nog geen bod";
        echo "<div style='border:1px solid #ccc; padding:10px;'>
            <img src='{$s['image_url']}' width='150'><br>
            Merk: {$s['brand']}<br>
            Maat: {$s['size']}<br>
            Conditie: {$s['condition']}<br>
            Hoogste bod: {$bid}<br>
            <a href='sneaker_detail.php?id={$s['id']}'>Bekijk</a>
        </div>";
    endforeach;
    echo "</div>";
else:
    echo "<p>Geen sneakers beschikbaar.</p>";
endif;
?>