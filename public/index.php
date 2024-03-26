<?php

// Chargement du fichier de configuration et des dépendances
require_once __DIR__ . '/../config/Config.php';
// Imaginons que Config.php charge aussi un autoloader pour vos classes

// Démarrage de la session
session_start();

// Une implémentation très basique de routage
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/../src/Controller/MainController.php';
        $controller = new MainController();
        $controller->index();
        break;
    case '/voitures' :
        require __DIR__ . '/../src/Controller/CarController.php';
        $controller = new CarController();
        $controller->listCars();
        break;
    case '/puffs' :
        require __DIR__ . '/../src/Controller/PuffController.php';
        $controller = new PuffController();
        $controller->listPuffs();
        break;
    // Ajoutez d'autres cas selon vos besoins
    default:
        // Gestion des cas non trouvés : vous pourriez vouloir charger une vue 404 ici
        header('HTTP/1.0 404 Not Found');
        require __DIR__ . '/../src/View/404.php';
        break;
}

// Note: Ce code suppose que chaque contrôleur a une méthode correspondant à l'action à effectuer.
