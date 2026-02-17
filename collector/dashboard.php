<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();
?>

<link rel="stylesheet" href="../assets/css/style.css">

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="../public/marketplace.php">Marktplaats</a>
    <a href="add_sneaker.php">Sneaker toevoegen</a>
    <a href="../public/logout.php">Uitloggen</a>
</div>

<div class="container">


<h2>Collector Dashboard</h2>
<p>Welkom gebruiker ID: <?php echo $_SESSION['user_id']; ?></p>

<h3>Mijn Sneakers (My Closet)</h3>

<?php
$stmt = $pdo->prepare("SELECT * FROM sneakers WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$sneakers = $stmt->fetchAll();

if(empty($sneakers)){
    echo "<p>Geen sneakers toegevoegd.</p>";
} else {
    foreach($sneakers as $s):

        echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:15px;'>
            <img src='{$s['image_url']}' width='150'><br>
            Merk: {$s['brand']}<br>
            Maat: {$s['size']}<br>
            Conditie: {$s['condition']}<br>
            Status: {$s['status']}<br>";

      $stmt2 = $pdo->prepare("SELECT * FROM bids WHERE sneaker_id=? ORDER BY amount DESC LIMIT 1");
$stmt2->execute([$s['id']]);
$highest_bid = $stmt2->fetch();

if($highest_bid){
    echo "Hoogste bod: €" . $highest_bid['amount'] . "<br>";

 
    if($s['status'] == 'active'){
        echo "<form method='POST' action='accept_bid.php'>
                <input type='hidden' name='sneaker_id' value='{$s['id']}'>
                <input type='hidden' name='bid_id' value='{$highest_bid['id']}'>
                <button type='submit'>Accepteer hoogste bod</button>
              </form>";
    }
} else {
    echo "Nog geen bod.<br>";
}

        echo "</div>";

    endforeach;
}
?>
