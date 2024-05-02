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
		<section class="dashboard">
			<!-- <h1 class="heading">Tableau de bord</h1> -->
			<div class="box-container">

				<div class="box">
    				<h3>Statistiques de vente des voitures</h3>
    				<canvas id="myChart" style="display: block; box-sizing: border-box; height: 617px; width: 1235px; "></canvas> 
				</div>

				<div class="box">
    				<h3>Statistiques de vente des Vapes</h3>
    				<canvas id="myChartpuff" style="display: block; box-sizing: border-box; height: 617px; width: 1235px; "></canvas> 
				</div>
				
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Quantité vendue par produit',
                data: [],
                backgroundColor: ['red', 'green', 'blue', 'orange', 'brown', 'yellow'],
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

    function updateChart() {
        fetch('get_sales_data.php')
        .then(response => response.json())
        .then(data => {
            const productNames = data.map(item => item.product_name);
            const quantities = data.map(item => item.total_quantity);

            myChart.data.labels = productNames;
            myChart.data.datasets[0].data = quantities;
            myChart.update();
        })
        .catch(error => console.error('Error:', error));
    }

    setInterval(updateChart, 1000); 
});
</script>

<canvas id="myChartpuff"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('myChartpuff').getContext('2d');
    var myChart = new Chart(ctx, {
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
                text: "World Wide Wine Production" // Modifiez le titre selon le besoin
            }
        }
    });

    function updateChart() {
        fetch('get_sales_data_puff.php')
        .then(response => response.json())
        .then(data => {
            const productNames = data.map(item => item.product_name);
            const quantities = data.map(item => item.total_quantity);
            const colors = data.map(() => '#' + Math.floor(Math.random()*16777215).toString(16));

            myChart.data.labels = productNames;
            myChart.data.datasets[0].data = quantities;
            myChart.data.datasets[0].backgroundColor = colors;
            myChart.update();
        })
        .catch(error => console.error('Error:', error));
    }

    updateChart(); // Chargez les données initialement
    setInterval(updateChart, 10000); // Met à jour le graphique toutes les minutes
});
</script>

</body>

</html>