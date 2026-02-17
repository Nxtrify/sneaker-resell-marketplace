<?php
require_once "../includes/auth.php";
requireLogin();
requireAdmin();
?>

<h2>Admin Dashboard</h2>
<p>Welkom Admin</p>

<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();
requireAdmin();

$stmt = $pdo->query("SELECT s.*, u.email as seller_email FROM sneakers s 
                     JOIN users u ON s.user_id=u.id 
                     WHERE s.status='verification'");
$sneakers = $stmt->fetchAll();
?>

<h2>Admin Dashboard - Verificaties</h2>

<?php if ($sneakers): ?>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Merk</th>
        <th>Maat</th>
        <th>Conditie</th>
        <th>Verkoper</th>
        <th>Acties</th>
    </tr>
    <?php foreach($sneakers as $s): ?>