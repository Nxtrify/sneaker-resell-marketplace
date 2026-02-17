<p><a href="../public/logout.php">Uitloggen</a></p>

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
         <tr>
        <td><?php echo $s['id']; ?></td>
        <td><?php echo $s['brand']; ?></td>
        <td><?php echo $s['size']; ?></td>
        <td><?php echo $s['condition']; ?></td>
        <td><?php echo $s['seller_email']; ?></td>
        <td>
            <a href="verify_sneaker.php?id=<?php echo $s['id']; ?>&decision=approved">Goedkeuren</a> | 
            <a href="verify_sneaker.php?id=<?php echo $s['id']; ?>&decision=rejected">Afkeuren</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>Geen sneakers in verificatie.</p>
<?php endif; ?>