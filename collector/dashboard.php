<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();
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

    <h2 style="margin-bottom:5px;">Mijn Dashboard</h2>
    <p style="color:#777; margin-bottom:30px;">
        Beheer hier jouw sneakers en biedingen.
    </p>

    <h3>Mijn Sneakers</h3>

<?php
$stmt = $pdo->prepare("SELECT * FROM sneakers WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$sneakers = $stmt->fetchAll();

if(empty($sneakers)){
    echo "<p>Geen sneakers toegevoegd.</p>";
} else {

    echo "<div class='grid'>";

    foreach($sneakers as $s){

        echo "<div class='card'>";

        echo "<img src='{$s['image_url']}' 
                    style='width:100%; border-radius:10px; margin-bottom:10px;'>";

        echo "<strong>{$s['brand']}</strong><br>";
        echo "Maat: {$s['size']}<br>";
        echo "Conditie: {$s['condition']}<br>";

        echo "Status: 
              <span class='badge {$s['status']}'>
                  {$s['status']}
              </span><br><br>";

        // Hoogste bod ophalen
        $stmt2 = $pdo->prepare("SELECT * FROM bids WHERE sneaker_id=? ORDER BY amount DESC LIMIT 1");
        $stmt2->execute([$s['id']]);
        $highest_bid = $stmt2->fetch();

   if($highest_bid){
    echo "<strong>Hoogste bod:</strong> €" . $highest_bid['amount'] . "<br><br>";

    if($s['status'] == 'active'){
        echo "<form method='POST' action='accept_bid.php'>
                <input type='hidden' name='sneaker_id' value='{$s['id']}'>
                <input type='hidden' name='bid_id' value='{$highest_bid['id']}'>
                <button type='submit'>Accepteer hoogste bod</button>
              </form>";
    }

} else {
    echo "Nog geen bod.<br><br>";
}


if($s['status'] == 'active'){
    echo "<form method='POST' action='delete_sneaker.php'
            onsubmit=\"return confirm('Weet je zeker dat je deze sneaker wil verwijderen?');\">
            <input type='hidden' name='sneaker_id' value='{$s['id']}'>
            <button type='submit' style='background:#f44336; margin-top:10px;'>
                Verwijderen
            </button>
          </form>";
}

?>