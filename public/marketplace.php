<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();

$stmt = $pdo->query("
    SELECT s.*, 
    (SELECT MAX(amount) FROM bids WHERE sneaker_id = s.id) AS highest_bid
    FROM sneakers s
    WHERE s.status = 'active'
");
$sneakers = $stmt->fetchAll();
?>

<link rel="stylesheet" href="../Assets/style.css">

<div class="navbar">
    <div class="nav-left">
        <a href="../collector/dashboard.php">Dashboard</a>
        <a href="marketplace.php">Marktplaats</a>
        <a href="/SneakerProject/collector/add_sneaker.php">Sneaker toevoegen</a>
    </div>

    <div class="nav-right">
        <span><?php echo $_SESSION['email']; ?></span>
        <a href="logout.php" style="color:white;">Uitloggen</a>
    </div>
</div>

<div class="container">

    <h2 style="margin-bottom:5px;">Marketplace</h2>
    <p style="color:#777; margin-bottom:30px;">
        Bekijk beschikbare sneakers en plaats een bod.
    </p>

<?php
if(empty($sneakers)){
    echo "<p>Geen sneakers beschikbaar.</p>";
} else {

    echo "<div class='grid'>";

    foreach($sneakers as $s){

        echo "<div class='card'>";

        echo "<a href='sneaker_detail.php?id={$s['id']}' style='text-decoration:none; color:black;'>";

        echo "<img src='{$s['image_url']}' 
                    style='width:100%; border-radius:10px; margin-bottom:10px;'>";

        echo "<strong>{$s['brand']}</strong><br>";
        echo "Maat: {$s['size']}<br>";
        echo "Conditie: {$s['condition']}<br><br>";

        if($s['highest_bid']){
            echo "<strong>Hoogste bod:</strong> €{$s['highest_bid']}";
        } else {
            echo "Nog geen bod";
        }

        echo "</a>";
        echo "</div>";
    }

    echo "</div>";
}
?>

</div>
