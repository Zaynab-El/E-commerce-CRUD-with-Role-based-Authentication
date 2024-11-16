<?php
session_start();

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost:3306;dbname=produits_db", 'root', '123456');

// Récupérer les produits
$sql = "SELECT * FROM produits";  // Assurez-vous que la table produits existe dans la base de données
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Récupérer tous les produits sous forme de tableau associatif

// Afficher le panier s'il existe
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<h2>Your Cart</h2><ul>";
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Récupérer les informations du produit à partir de la base de données
        $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo "<li>{$product['title']} x $quantity - " . number_format($product['price'] * $quantity, 2) . "€</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>Your cart is empty.</p>";
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Shop</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container pt-4">
        <h1>Welcome to Our Shop</h1>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <!-- Vérification de l'image du produit, affichage d'une image par défaut si l'image est manquante -->
                        <img src="<?= !empty($product['thumbnail']) ? $product['thumbnail'] : 'default-image.jpg' ?>" 
                             alt="<?= $product['title'] ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['title'] ?></h5>
                            <p class="card-text">Price: <?= number_format($product['price'], 2) ?>€</p>
                            <form action="addToCart.php" method="post">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                                <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
