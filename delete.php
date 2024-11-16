<?php
session_start(); // Démarrer la session

// Vérification que l'utilisateur est un administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
    exit("Accès refusé.");
}

$id = $_GET['idd'];

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost:3306;dbname=produits_db", 'root', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier que l'utilisateur existe avant de supprimer
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Supprimer l'utilisateur
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    
    header("Location: /index.php"); // Rediriger après suppression
} else {
    header("Location: /index.php?msg=Utilisateur introuvable");
}
?>
