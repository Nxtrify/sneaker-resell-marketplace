<?php
require_once "../config/database.php";
require_once "../includes/auth.php";
requireLogin();
requireAdmin();

$stmt = $pdo->query("
    SELECT s.*, u.email as seller_email 
    FROM sneakers s 
    JOIN users u ON s.user_id = u.id 
    WHERE s.status = 'verification'
");
$sneakers = $stmt->fetchAll();
?>

<link rel="stylesheet" href="../Assets/style.css">

<div class="navbar">
    <div class="nav-left">
        <a href="dashboard.php">Admin Dashboard</a>
    </div>

    <div class="nav-right">
        <span><?php echo $_SESSION['email']; ?></span>
        <a href="../public/logout.php" style="color:white;">Uitloggen</a>
    </div>
</div>

<div class="container">

    <h2>Verificaties</h2>
    <p style="color:#777; margin-bottom:30px;">
        Keur sneakers goed of wijs ze af voordat ze live gaan.
    </p>

<?php if(empty($sneakers)): ?>

    <div class="card">
        <p>Geen sneakers in verificatie.</p>
    </div>

<?php else: ?>

    <div class="card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>ID</th>
                    <th>Merk</th>
                    <th>Maat</th>
                    <th>Conditie</th>
                    <th>Verkoper</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($sneakers as $s): ?>
                <tr>
                    <td>
                        <a href="<?php echo htmlspecialchars($s['image_url']); ?>" target="_blank">
    <img src="<?php echo htmlspecialchars($s['image_url']); ?>" 
         class="admin-thumb">
</a>

                    </td>
                    <td><?php echo $s['id']; ?></td>
                    <td><?php echo htmlspecialchars($s['brand']); ?></td>
                    <td><?php echo $s['size']; ?></td>
                    <td><?php echo htmlspecialchars($s['condition']); ?></td>
                    <td><?php echo htmlspecialchars($s['seller_email']); ?></td>
                    <td>
                        <a href="verify_sneaker.php?id=<?php echo $s['id']; ?>&decision=approved">
                            <button class="btn-success">Goedkeuren</button>
                        </a>

                        <a href="verify_sneaker.php?id=<?php echo $s['id']; ?>&decision=rejected">
                            <button class="btn-danger">Afkeuren</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>

</div>
