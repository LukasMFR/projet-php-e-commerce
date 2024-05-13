<?php
// Code utilisé pour afficher les erreurs et les debugs
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Informations de connexion à la base de données
// $dsn = 'mysql:host=localhost;dbname=autocar;charset=utf8mb4';
$dsn = 'mysql:host=localhost;dbname=autocar';
$db_user = 'root';
$db_password = '';

try {
	$conn = new PDO($dsn, $db_user, $db_password);
	// Définit le mode d'erreur pour générer des exceptions
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	// Afficher les erreurs de connexion à la base de données
	die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Ajouter le manifest et le service worker
echo '<link rel="manifest" href="/manifest.json">';
echo '<script>';
echo 'if ("serviceWorker" in navigator) {';
echo '  navigator.serviceWorker.register("/service-worker.js").then(function(registration) {';
echo '    console.log("Service Worker registered with scope:", registration.scope);';
echo '  }).catch(function(error) {';
echo '    console.log("Service Worker registration failed:", error);';
echo '  });';
echo '}';
echo '</script>';

// Tableau de traduction des mois
$mois = [
    'January' => 'janvier',
    'February' => 'février',
    'March' => 'mars',
    'April' => 'avril',
    'May' => 'mai',
    'June' => 'juin',
    'July' => 'juillet',
    'August' => 'août',
    'September' => 'septembre',
    'October' => 'octobre',
    'November' => 'novembre',
    'December' => 'décembre'
];

// Fonction pour générer un ID unique
function unique_id()
{
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charLength = strlen($chars);
	$randomString = '';
	for ($i = 0; $i < 20; $i++) {
		$randomString .= $chars[mt_rand(0, $charLength - 1)];
	}
	return $randomString;
}
?>