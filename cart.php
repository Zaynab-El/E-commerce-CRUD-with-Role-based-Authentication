<?php
session_start();

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost:3306;dbname=produits_db", 'root', '123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si le panier existe et contient des produits
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<h2>Your Cart</h2><ul>";

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Récupérer les informations du produit à partir de la base de données
        $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
        $stmt->execute([$product_id]); // Assurez-vous que le tableau contient un seul élément

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo "<li>{$product['title']} x $quantity - " . number_format($product['price'] * $quantity, 2) . "€</li>";
        } else {
            echo "<li>Product ID $product_id not found in database.</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>Your cart is empty.</p>";
}
