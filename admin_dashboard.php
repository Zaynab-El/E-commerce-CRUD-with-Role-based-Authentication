<?php
session_start();
require 'session.php';  // Fichier contenant les fonctions de gestion des sessions

// Vérifier que l'utilisateur est connecté et qu'il est admin
if (!isLoggedIn() || !isAdmin()) {
    header("Location: login.php");  // Rediriger vers la page de login si non connecté ou non admin
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <p>Here you can manage users, products, and orders.</p>
    <!-- Ajoutez ici des liens ou des fonctionnalités pour l'administration -->
    <a href="manage_users.php">Manage Users</a><br>
    <a href="manage_products.php">Manage Products</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>