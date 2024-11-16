<?php
session_start();
require 'session.php';

// Vérifier que l'utilisateur est connecté et qu'il est un guest
if (!isLoggedIn() || $_SESSION['user']['role'] !== 'guest') {
    header("Location: login.php");  // Rediriger vers la page de login si non connecté ou non guest
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, Guest</title>
</head>
<body>
    <h1>Welcome to our Store, Guest!</h1>
    <p>Browse our products and add them to your cart.</p>
    <!-- Ajoutez ici des liens ou des fonctionnalités pour les guests -->
    <a href="index.php">Shop Now</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
