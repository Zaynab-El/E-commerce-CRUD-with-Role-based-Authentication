<?php
session_start(); // Démarrer la session

// Vérification que l'utilisateur est un administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
    exit("Accès refusé.");
}

try {
    // Vérification que le formulaire est bien soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $role = $_POST['role'];

        // Vérification de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: add.php?msg=Email invalide");
            exit;
        }

        // Connexion à la base de données
        $pdo = new PDO("mysql:host=localhost:3306;dbname=produits_db", 'root', '123456');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insérer l'utilisateur dans la base de données
        $sql = "INSERT INTO users (email, pass, role) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->bindValue(2, password_hash($pass, PASSWORD_DEFAULT), PDO::PARAM_STR);  // Stocker le mot de passe de manière sécurisée
        $stmt->bindValue(3, $role, PDO::PARAM_STR);

        $stmt->execute();

        header("Location: /index.php"); // Rediriger après ajout
    }
} catch (PDOException $e) {
    // En cas d'erreur, rediriger vers la page d'accueil avec un message d'erreur
    header("Location: /index.php?msg=une+erreur");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
</head>
<body>
    <h2>Add New User</h2>
    <form method="post" action="add.php">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        
        <label for="pass">Password:</label>
        <input type="password" name="pass" id="pass" required><br>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="admin">Admin</option>
            <option value="guest">Guest</option>
        </select><br>
        
        <button type="submit">Add User</button>
    </form>
</body>
</html>
