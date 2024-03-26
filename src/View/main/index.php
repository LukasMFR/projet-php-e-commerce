<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="/public/assets/css/style.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body>
    <header>
        <h1>Bienvenue sur AutoCar</h1>
    </header>
    <nav>
        <!-- Liens de navigation ou menu ici -->
    </nav>
    <main>
        <section>
            <h2><?php echo htmlspecialchars($title); ?></h2>
            <p><?php echo htmlspecialchars($description); ?></p>
        </section>
        <!-- D'autres sections ou contenus ici -->
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> AutoCar. Tous droits réservés.</p>
    </footer>
</body>
</html>
