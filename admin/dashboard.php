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
				<h3>Statistiques des ventes de voitures</h3>
				<canvas id="carsChart"></canvas>
			</div>
			<div class="box">
				<h3>Statistiques des ventes de Vapes</h3>
				<canvas id="vapesChart"></canvas>
			</div>
			<div class="box">
				<h3>Statistiques des ventes de voitures</h3>
				<canvas id="carsChartcam"></canvas>
			</div>
			<div class="box">
				<h3>Statistiques des ventes de Vapes</h3>
				<canvas id="puffsChartCam"></canvas>
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
			var productColors = {
        "McLaren 720s": "red", 
        "Alpine A110 R": "blue", 
        "Lamborghini Urus": "green", 
        "Mercedes AMG GT2": "#87CEEB",
		"Lamborghini Revuelto": "orange",
		"Bugatti La Voiture Noire": "#4d4d4d",
		"Ferrari SP51": "#8B0000" 
    	};
			var ctxCars = document.getElementById('carsChart').getContext('2d');
			var carsChart = new Chart(ctxCars, {
				type: 'bar',
				data: {
					labels: [], // Labels seront remplis par les données de la BDD
					datasets: [{
						label: 'Quantité vendue par produit',
						data: [], // Données seront remplies par les données de la BDD
						backgroundColor: [], // Vous pouvez aussi définir dynamiquement
						borderColor: 'black',
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

			function updateCarsChart() {
				fetch('get_sales_data.php')
					.then(response => response.json())
					.then(data => {
						carsChart.data.labels = data.map(item => item.product_name);
						carsChart.data.datasets[0].data = data.map(item => item.total_quantity);
						carsChart.data.datasets[0].backgroundColor = data.map(item => productColors[item.product_name] || "#999999");
						carsChart.update();
					})
					.catch(error => console.error('Error:', error));
			}

			updateCarsChart();
			// Vous pouvez également configurer un intervalle pour rafraîchir le graphique régulièrement
			// setInterval(updateCarsChart, 10000); // Rafraîchit le graphique toutes les 10 secondes
		});
	</script>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var productColors = {
        "Puff Superéthanol E85": "red", 
        "Puff Sans Plomb 95": "blue", 
        "Puff Gazole": "green", 
        "Puff électrique": "#87CEEB",
		"Puff Supercarburants SP95": "orange",
		"Puff naturel": "#90EE90" 
    	};
			var ctxVapes = document.getElementById('vapesChart').getContext('2d');
			var vapesChart = new Chart(ctxVapes, {
				type: 'bar',
				data: {
					labels: [], // Labels seront remplis par les données de la BDD
					datasets: [{
						label: 'Quantité vendue par produit',
						data: [], // Données seront remplies par les données de la BDD
						backgroundColor: [], // Vous pouvez aussi définir dynamiquement
						borderColor: 'black',
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

			function updateVapesChart() {
				fetch('get_sales_data_puff.php')  // Assurez-vous que ce chemin est correct
					.then(response => response.json())
					.then(data => {
						vapesChart.data.labels = data.map(item => item.product_name);
						vapesChart.data.datasets[0].data = data.map(item => item.total_quantity);
						vapesChart.data.datasets[0].backgroundColor = data.map(item => productColors[item.product_name] || "#999999");
						vapesChart.update();
					})
					.catch(error => console.error('Error:', error));
			}

			updateVapesChart();
			// Vous pouvez également configurer un intervalle pour rafraîchir le graphique régulièrement
			// setInterval(updateVapesChart, 10000); // Rafraîchit le graphique toutes les 10 secondes
		});
	</script>


	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var productColors = {
        "McLaren 720s": "red", 
        "Alpine A110 R": "blue", 
        "Lamborghini Urus": "green", 
        "Mercedes AMG GT2": "#87CEEB",
		"Lamborghini Revuelto": "orange",
		"Bugatti La Voiture Noire": "#4d4d4d",
		"Ferrari SP51": "#8B0000" 
    	};
    var ctxPie = document.getElementById('carsChartcam').getContext('2d');
    var pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: [], // Les labels seront chargés dynamiquement
            datasets: [{
                backgroundColor: [], // Les couleurs seront définies dynamiquement
                data: [] // Les données seront chargées dynamiquement
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Statistiques des ventes de voitures'
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    function updatePieChart() {
        fetch('get_sales_data.php')  // Assurez-vous que le chemin est correct.
            .then(response => response.json())
            .then(data => {
                pieChart.data.labels = data.map(item => item.product_name);
                pieChart.data.datasets[0].data = data.map(item => item.total_quantity);
				pieChart.data.datasets[0].backgroundColor = data.map(item => productColors[item.product_name] || "#999999");
                pieChart.update();
            })
            .catch(error => console.error('Error:', error));
    }

    updatePieChart(); // Appel initial pour charger les données
});
	</script>
		
	<script>
		document.addEventListener('DOMContentLoaded', function () {
    // Tableau des couleurs assignées à chaque produit
    var productColors = {
        "Puff Superéthanol E85": "red", 
        "Puff Sans Plomb 95": "blue", 
        "Puff Gazole": "green", 
        "Puff électrique": "#87CEEB",
		"Puff Supercarburants SP95": "orange",
		"Puff naturel": "#90EE90" 
    };

    // Votre code existant pour la configuration du graphique commence ici...
    var ctxPuffs = document.getElementById('puffsChartCam').getContext('2d');
    var puffsChartCam = new Chart(ctxPuffs, {
        type: 'pie',
        data: {
            labels: [], 
            datasets: [{
                backgroundColor: [], 
                data: [] 
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Statistiques des ventes de Puffs'
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Fonction pour mettre à jour le graphique avec les données récupérées
    function updatePuffsChart() {
        fetch('get_sales_data_puff2.php')
            .then(response => response.json())
            .then(data => {
                puffsChartCam.data.labels = data.map(item => item.product_name);
                puffsChartCam.data.datasets[0].data = data.map(item => item.total_quantity);
                puffsChartCam.data.datasets[0].backgroundColor = data.map(item => productColors[item.product_name] || "#999999"); // Utilisation des couleurs prédéfinies
                puffsChartCam.update();
            })
            .catch(error => console.error('Error:', error));
    }

    updatePuffsChart(); // Appel initial pour charger les données
});
	</script>

</body>

</html>