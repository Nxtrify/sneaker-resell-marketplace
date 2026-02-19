<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Ongeldig e-mailadres.";
    } elseif (strlen($password) < 6) {
        $error = "Wachtwoord moet minimaal 6 karakters zijn.";
    } elseif ($password !== $confirm) {
        $error = "Wachtwoorden komen niet overeen.";
    } else {

        // Check of email al bestaat
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "Dit e-mailadres is al geregistreerd.";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("
                INSERT INTO users (email, password, role, blocked)
                VALUES (?, ?, 'collector', 0)
            ");

            $stmt->execute([$email, $hashedPassword]);

            $success = "Account succesvol aangemaakt! Je kan nu inloggen.";
        }
    }
}
?>

<link rel="stylesheet" href="../assets/style.css">

<div class="auth-wrapper">

    <link rel="stylesheet" href="../assets/style.css">

<div class="auth-container">

    <div class="logo">
        <img src="../assets/logo.png" alt="SneakerResell Logo" class="login-logo">
    </div>

    <div class="auth-card">
        <h2>Registreren</h2>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <input type="password" name="confirm_password" placeholder="Herhaal wachtwoord" required>

            <button type="submit">Account aanmaken</button>
        </form>

        <p class="auth-switch">
            Al een account? <a href="login.php">Login hier</a>
        </p>
    </div>
</div>
