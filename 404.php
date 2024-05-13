<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page non trouvée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
        }

        h1 {
            font-size: 2em;
            color: #333;
        }

        p {
            color: #666;
        }

        a {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        a:hover {
            background: #0056b3;
        }
    </style>
    <?php include 'components/pwa-setup.php'; ?>
</head>

<body>
    <h1>Erreur 404</h1>
    <p>Désolé, la page que vous cherchez n'existe pas ou une autre erreur s'est produite.</p>
    <p>Vous pouvez retourner à la <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/">page d'accueil</a> ou faire une recherche.</p>
</body>

</html>