<?php
require_once "../includes/auth.php";
requireLogin();
?>

<h2>Collector Dashboard</h2>
<p>Welkom gebruiker ID: <?php echo $_SESSION['user_id']; ?></p>
