<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
} else {
	$user_id = '';
}

if (isset($_POST['logout'])) {
	session_destroy();
	header("location: login.php");
}
?>
<style type="text/css">
	<?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="img/favicon-64.png">
	<title>Page d'accueil - Road Luxury</title>
</head>

<section class="home-section">
	<div class="video-container">
		<video autoplay loop muted playsinline>
			<source src="image/videoPres.mp4" type="video/mp4">
		</video>
		<div class="overlay"></div>
		<div class="video-detail">
			<h1>Bienvenue chez Road Luxury</h1>
			<p>L'art de l'élégance automobile.</p>
		</div>
	</div>

</section>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<section class="brand">
			<div class="box-container">
				<div class="box">
					<img src="img/brand (1).jpg">
				</div>
				<div class="box">
					<img src="img/FerariLogo.png">
				</div>
				<div class="box">
					<img src="img/brand (3).jpg">
				</div>
				<div class="box">
					<img src="img/brand (4).jpg">
				</div>
				<div class="box">
					<img src="img/brand (5).jpg">
				</div>
			</div>
		</section>
		<section class="container">
			<div class="box-container">

				<div class="box">
					<img src="img/imagepres.jpg" class="rounded">
				</div>
				<div class="box">
					<img src="img/download.png" class="logo-small">
					<span>Road Luxury</span>
					<h1>Luxe et performance</h1>
					<p>Explorez l'exclusivité avec Road Luxury : chaque trajet se transforme en un récit de prestige.
						Découvrez une sélection premium et initiez votre voyage avec grandeur.</p>
				</div>
			</div>
		</section>
		<section class="shop">
			<div class="title">
				<img src="img/download.png" class="logo-small">
				<h1>Produits tendance</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="img/maserati.jpg">
					<a href="view_page.php?pid=BLTtlhOgq1cuz7plh4Ia" class="btn">Acheter maintenant</a>
					<h1>Maserati MC20 Cielo</h1>
				</div>
				<div class="box">
					<img src="img/bugatienoir.jpg">
					<a href="view_page.php?pid=jo35YMmBWpvbCMB65UdA" class="btn">Acheter maintenant</a>
					<h1>Bugatti La voiture Noire</h1>
				</div>
				<div class="box">
					<img src="img/lambo.jpg">
					<a href="view_page.php?pid=aSBHDzG26iXurm6cfoNv" class="btn">Acheter maintenant</a>
					<h1>Lamborghini Revuelto</h1>
				</div>
			</div>
			<div class="title">
				<img src="img/download.png" class="logo-small">
				<h1>Bientôt disponible</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="img/mercedes.jpg">
					<a href="view_products.php" class="btn">Précommander</a>
					<h1>Mercedes-Benz AMG GT3 Edition 55</h1>
				</div>
				<div class="box">
					<img src="img/astonmartine.jpg">
					<a href="view_products.php" class="btn">Précommander</a>
					<h1>Aston Martin Vantage GT3</h1>
				</div>
				<div class="box">
					<img src="img/MC3.jpg">
					<a href="view_products.php" class="btn">Précommander</a>
					<h1>McLaren 720s GT3 X</h1>
				</div>

		</section>
		<section class="shop-category">
			<div class="title">
				<img src="img/download.png" class="logo-small">
				<h1>Gamme de puffs</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="img/6.jpg">
					<div class="detail">
						<span>GROSSES PROMOTIONS</span>
						<h1>Sur une large sélection de puffs</h1>
						<a href="view_products.php" class="btn">Acheter maintenant</a>
					</div>
				</div>
				<div class="box">
					<img src="img/7.jpg">
					<div class="detail">
						<span>Nouveaux goûts</span>
						<h1>Testez notre puff goût essence !</h1>
						<a href="view_products.php" class="btn">Acheter maintenant</a>
					</div>
				</div>
			</div>
		</section>

		<section class="services">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Pourquoi nous choisir</h1>
				<p>Qualité supérieure, prix compétitifs, service client exceptionnel.</p>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="img/icon2.png">
					<div class="detail">
						<h3>Grandes économies</h3>
						<p>Économisez gros sur chaque commande</p>
					</div>
				</div>
				<div class="box">
					<img src="img/icon1.png">
					<div class="detail">
						<h3>Support 24/7</h3>
						<p>Assistance personnelle</p>
					</div>
				</div>
				<div class="box">
					<img src="img/icon0.png">
					<div class="detail">
						<h3>Offres spéciales sur les véhicules</h3>
						<p>Promotions à l'occasion des fêtes</p>
					</div>
				</div>
				<div class="box">
					<img src="img/icon.png">
					<div class="detail">
						<h3>Livraison internationale</h3>
						<p>Expédition partout dans le monde</p>
					</div>
				</div>
			</div>
		</section>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>

</html>