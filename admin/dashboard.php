<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}
?>
<style>
	<?php include 'admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- font awesome cdn link  -->
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="../img/favicon-64.png">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<title>Tableau de bord admin - Road Luxury</title>

	
</head>

<body>	
	<?php include '../components/admin_header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Tableau de bord</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Accueil </a><span>/ Tableau de bord</span>
		</div>

		<section class="dashboard-stat">	
		<div class="box">
                <h3>Statistiques des ventes de Vapes</h3>
                <canvas id="vapesChart"></canvas>
            </div>
            <div class="box">
                <h3>Statistiques des ventes de voitures</h3>
                <canvas id="carsChart"></canvas>
            </div>
            <div class="box">
				<h3>Statistiques des ventes de Vapes</h3>
				<canvas id="salesRegionChart"></canvas>
			</div>
			<div class="box">
				<h3>Statistiques des ventes de voitures</h3>
				<canvas id="salesTypeChart"></canvas>
			</div>
		</section>

		<section class="dashboard">	
			<h1 class="heading">Tableau de bord</h1>
			<div class="box-container">
				<!-- Bloc pour les produits ajoutés -->
				<div class="box">
					<?php
					$select_post = $conn->prepare("SELECT * FROM `products`");
					$select_post->execute();
					$number_of_posts = $select_post->rowCount();
					?>
					<h3><?= $number_of_posts; ?></h3>
					<p>Produits ajoutés</p>
					<a href="add_posts.php" class="btn">Ajouter un nouveau produit</a>
				</div>

				<!-- Bloc pour les produits actifs -->
				<div class="box">
					<?php
					$select_active_post = $conn->prepare("SELECT * FROM `products` WHERE status = 'actif'");
					$select_active_post->execute();
					$number_of_active_post = $select_active_post->rowCount();
					?>
					<h3><?= $number_of_active_post; ?></h3>
					<p>Produits actifs</p>
					<a href="view_posts.php" class="btn">Voir les produits</a>
				</div>

				<!-- Bloc pour les produits désactivés -->
				<div class="box">
					<?php
					$select_deactive_post = $conn->prepare("SELECT * FROM `products` WHERE status = 'inactif'");
					$select_deactive_post->execute();
					$number_of_deactive_post = $select_deactive_post->rowCount();
					?>
					<h3><?= $number_of_deactive_post; ?></h3>
					<p>Produits désactivés</p>
					<a href="view_posts.php" class="btn">Voir les produits</a>
				</div>

				<!-- Bloc pour les utilisateurs -->
				<div class="box">
					<?php
					$select_users = $conn->prepare("SELECT * FROM `users`");
					$select_users->execute();
					$number_of_users = $select_users->rowCount();
					?>
					<h3><?= $number_of_users; ?></h3>
					<p>Comptes utilisateurs</p>
					<a href="user_accounts.php" class="btn">Voir les utilisateurs</a>
				</div>

				<!-- Bloc pour les administrateurs -->
				<div class="box">
					<?php
					$select_admins = $conn->prepare("SELECT * FROM `admin`");
					$select_admins->execute();
					$number_of_admins = $select_admins->rowCount();
					?>
					<h3><?= $number_of_admins; ?></h3>
					<p>Comptes admins</p>
					<a href="admin_accounts.php" class="btn">Voir les admins</a>
				</div>

				<!-- Bloc pour les messages -->
				<div class="box">
					<?php
					$select_comments = $conn->prepare("SELECT * FROM `message`");
					$select_comments->execute();
					$numbers_of_comments = $select_comments->rowCount();
					?>
					<h3><?= $numbers_of_comments; ?></h3>
					<p>Messages ajoutés</p>
					<a href="admin_message.php" class="btn">Voir les messages</a>
				</div>

				<!-- Divers blocs pour les commandes -->
				<!-- Bloc pour les commandes annulées -->
				<div class="box">
					<?php
					$select_annulee_order = $conn->prepare("SELECT * FROM `orders` WHERE status = 'annulee'");
					$select_annulee_order->execute();
					$total_annulee_order = $select_annulee_order->rowCount();
					?>
					<h3><?= $total_annulee_order; ?></h3>
					<p>Total commandes annulées</p>
					<a href="admin_order.php" class="btn">Voir les commandes</a>
				</div>

				<!-- Bloc pour les commandes en cours -->
				<div class="box">
					<?php
					$select_confirm_order = $conn->prepare("SELECT * FROM `orders` WHERE status = 'en cours'");
					$select_confirm_order->execute();
					$total_confirm_order = $select_confirm_order->rowCount();
					?>
					<h3><?= $total_confirm_order; ?></h3>
					<p>Total commandes en cours</p>
					<a href="admin_order.php" class="btn">Voir les commandes</a>
				</div>

				<!-- Bloc pour le total des commandes -->
				<div class="box">
					<?php
					$select_total_order = $conn->prepare("SELECT * FROM `orders`");
					$select_total_order->execute();
					$total_total_order = $select_total_order->rowCount();
					?>
					<h3><?= $total_total_order; ?></h3>
					<p>Total commandes passées</p>
					<a href="admin_order.php" class="btn">Voir les commandes</a>
				</div>
			</div>

		</section>
	</div>

	<script src="script.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


	<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctxVapes = document.getElementById('vapesChart').getContext('2d');
    var vapesChart = new Chart(ctxVapes, {
        type: 'bar',
        data: {
            labels: ['Puff Superéthanol E85', 'Puff Sans Plomb 95', 'Puff Gazole', 'Puff électrique', 'Puff Supercarburants SP95', 'Puff naturel'], // Mettez ici vos données réelles
            datasets: [{
                label: 'Quantité vendue par produit',
                data: [5, 10],
                backgroundColor: ['red', 'blue', 'green', 'blue', 'blue', 'blue'],
                borderColor: ['black'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctxCars = document.getElementById('carsChart').getContext('2d');
    var carsChart = new Chart(ctxCars, {
        type: 'bar',
        data: {
            labels: ['Bugatti La Voiture Noire', 'Porsche 911 GT3 R', 'Lamborghini Revuelto', 'Lamborghini Urus', 'McLaren 720s', 
				'Maserati Granturismo', 'Alpine A110 R', 'Ferrari SP51', 'Mercedes AMG GT2'], // Mettez ici vos données réelles
            datasets: [{
                label: 'Quantité vendue par produit',
                data: [3, 7],
                backgroundColor: ['Bugatti La Voiture Noire', 'Porsche 911 GT3 R', 'Lamborghini Revuelto', 'Lamborghini Urus', 'McLaren 720s', 
				'Maserati Granturismo', 'Alpine A110 R', 'Ferrari SP51', 'Mercedes AMG GT2'],
                borderColor: ['black'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>


<script>
	document.addEventListener('DOMContentLoaded', function () {
    var regionCtx = document.getElementById('salesRegionChart').getContext('2d');
    var regionChart = new Chart(regionCtx, {
        type: 'pie',
        data: {
            labels: ['Nord', 'Sud', 'Est', 'Ouest'],  // Exemple de régions
            datasets: [{
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                data: [120, 150, 180, 90]  // Exemple de données
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Ventes par région'
            }
        }
    });

    var typeCtx = document.getElementById('salesTypeChart').getContext('2d');
    var typeChart = new Chart(typeCtx, {
        type: 'pie',
        data: {
            labels: ['Type 1', 'Type 2', 'Type 3'],  // Exemple de types de produits
            datasets: [{
                backgroundColor: ['#7E57C2', '#D4E157', '#29B6F6'],
                data: [210, 130, 170]  // Exemple de données
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Répartition des ventes par type'
            }
        }
    });
});
</script>

</body>

</html>