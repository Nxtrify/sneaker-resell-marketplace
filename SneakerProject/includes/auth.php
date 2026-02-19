<?php
session_start(); // Start sessie voor gebruikersauthenticatie

function isLoggedIn() {
    return isset($_SESSION['user_id']); // Controleert of gebruiker ingelogd is
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../public/login.php"); // Redirect naar login als niet ingelogd
        exit();
    }
}

function requireAdmin() {
    // Controleert of gebruiker admin rol heeft
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        die("Geen toegang.");
    }
}