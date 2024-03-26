<?php

class MainController {
    public function index() {
        // Charger les données nécessaires pour la vue, si nécessaire
        $data = [
            'title' => 'Bienvenue sur AutoCar',
            'description' => 'Découvrez notre sélection de voitures et de puffs.'
        ];

        // Afficher la vue de la page d'accueil
        // Le chemin peut varier en fonction de l'organisation de vos vues
        $this->loadView('main/index', $data);
    }

    private function loadView($viewPath, $data = []) {
        // Extrait les données pour qu'elles soient disponibles comme des variables dans la vue
        extract($data);

        // Inclut le fichier de la vue
        // Assurez-vous que le chemin d'accès correspond à l'organisation de vos fichiers de vue
        require __DIR__ . '/../View/' . $viewPath . '.php';
    }
}
