<?php
// Simuler une petite base de données de produits en utilisant des tableaux associatifs
$produits = [
    ['id' => 1, 'nom' => 'Voiture Modèle X', 'prix' => '50000', 'categorie' => 'voiture'],
    ['id' => 2, 'nom' => 'Voiture Modèle Y', 'prix' => '60000', 'categorie' => 'voiture'],
    ['id' => 3, 'nom' => 'Puff Modèle A', 'prix' => '75', 'categorie' => 'puff'],
    ['id' => 4, 'nom' => 'Puff Modèle B', 'prix' => '85', 'categorie' => 'puff'],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>AutoCar - Votre magasin de voitures et puffs</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Bienvenue chez AutoCar</h1>
    <h2>Nos produits</h2>
    <div class="produits">
        <?php foreach ($produits as $produit): ?>
            <div class="produit">
                <h3><?php echo $produit['nom']; ?></h3>
                <p>Prix: <?php echo $produit['prix']; ?> €</p>
                <p>Catégorie: <?php echo $produit['categorie']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
