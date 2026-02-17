<?php
require_once "../config/database.php";
require_once "../includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

     if ($user && password_verify($password, $user["password"])) {
        if ($user["blocked"] == 1) {
            $error = "Account is geblokkeerd.";
        } else {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["role"] = $user["role"];
            if ($user["role"] === "admin") {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../collector/dashboard.php");
            }
            exit();
        }
    } else {
        $error = "Onjuiste gegevens.";
    }
}
?>

<h2>Login</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Wachtwoord" required><br>
    <button type="submit">Login</button>
</form>