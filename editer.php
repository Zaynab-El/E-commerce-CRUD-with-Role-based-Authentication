<?php
session_start(); // Démarrer la session

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit("Accès refusé.");
}

// Charger les produits depuis le fichier JSON
$products = json_decode(file_get_contents("./products.json"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Products</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container pt-4">
        <h1>Manage Products</h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr id="<?= 'product_' . $product->id ?>">
                        <td><?= $product->id ?></td>
                        <td><?= htmlspecialchars($product->title) ?></td>
                        <td><input type="number" class="form-control text-end" value="1" min="1" id="qty_<?= $product->id ?>"></td>
                        <td><?= $product->price ?>€</td>
                        <td>
                            <!-- Bouton pour modifier ou supprimer le produit -->
                            <button class="btn btn-primary" onclick="addToCart(<?= $product->id ?>)">Add to Cart <i class="bi bi-basket"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Fonction pour ajouter un produit au panier
        function addToCart(productId) {
            const qty = document.querySelector('#qty_' + productId).value; // Récupérer la quantité
            fetch('/addToCart.php', {
                method: 'POST', // Utilisation de POST pour plus de sécurité
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `product_id=${productId}&quantity=${qty}` // Passer l'ID du produit et la quantité
            })
            .then(response => response.text())
            .then(data => {
                // Traiter la réponse du serveur (par exemple, rediriger ou afficher un message)
                console.log(data);
                alert('Product added to cart');
            })
            .catch(error => console.error('Error adding product to cart:', error));
        }
    </script>
</body>

</html>
