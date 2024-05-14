<?php
include 'components/connection.php';
session_start();

if (isset($_SESSION['success_msg'])) {
	$success_msg[] = $_SESSION['success_msg'];
	unset($_SESSION['success_msg']);
}

if (isset($success_msg)) {
	foreach ($success_msg as $message) {
		echo '<script>swal("' . $message . '", "" ,"success");</script>';
	}
}

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
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"> -->
</head>

<body>
	<?php include 'components/header.php'; ?>

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

	<div class="main">
		<section class="brand">
			<div class="box-container">
				<div class="top-brands">
					<img src="img/logo-mercedes.png">
				</div>
				<div class="top-brands">
					<img src="img/logo-ferrari.png">
				</div>
				<div class="top-brands">
					<img src="img/logo-aston-martin.png">
				</div>
				<div class="top-brands">
					<img src="img/logo-bugatti.png">
				</div>
				<div class="top-brands">
					<img src="img/logo-maserati.png">
				</div>
			</div>
		</section>
		<section class="container">
			<div class="welcome">
				<div class="box">
					<img src="img/imagepres.png" class="rounded">
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
				<img src="img/logobuff.webp" class="logo-small">
				<h1>Produits tendance</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="image/mc1.jpg">
					<a href="view_page.php?pid=BLTtlhOgq1cuz7plh4Ia" class="btn">Acheter</a>
					<h1>McLaren 720s</h1>
				</div>
				<div class="box">
					<img src="image/bugatienoir.jpg">
					<a href="view_page.php?pid=jo35YMmBWpvbCMB65UdA" class="btn">Acheter</a>
					<h1>Bugatti La voiture Noire</h1>
				</div>
				<div class="box" id="modelContainer">
					<img src="image/lambo4.jpg" alt="Lamborghini Revuelto" id="arTrigger"
						style="width: 100%; cursor: pointer;">
					<a href="view_page.php?pid=aSBHDzG26iXurm6cfoNv" class="btn">Acheter</a>
					<h1>Lamborghini Revuelto</h1>
				</div>
			</div>
			<div class="title">
				<img src="img/logotime.webp" class="logo-small">
				<h1>Bientôt disponible</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="image/mercedes.jpg">
					<a href="view_page.php?pid=bEvIK2PvwOqY4l8nuPTZ" class="btn">Précommander</a>
					<h1>Mercedes-Benz AMG GT3 Edition 55</h1>
				</div>
				<div class="box">
					<img src="image/aston.jpg">
					<a href="view_page.php?pid=rfA9q4uWC2JvzLCRmawT" class="btn">Précommander</a>
					<h1>Aston Martin Vantage GT3</h1>
				</div>
				<div class="box">
					<img src="image/MC3.jpg">
					<a href="view_page.php?pid=0I8ZbLUgrxn7qWNMzxPE" class="btn">Précommander</a>
					<h1>McLaren 720s GT3 X</h1>
				</div>

		</section>
		<section class="shop-category">
			<div class="title">
				<img src="img/logopuff.webp" class="logo-small">
				<h1>Gamme de puffs</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="img/6.jpg">
					<div class="detail">
						<span>GROSSES PROMOTIONS</span>
						<h1>Sur une large sélection de puffs</h1>
						<a href="view_puffs.php" class="btn">Acheter maintenant</a>
					</div>
				</div>
				<div class="box">
					<img src="img/7.jpg">
					<div class="detail">
						<span>Nouveaux goûts</span>
						<h1>Testez notre puff goût essence !</h1>
						<a href="view_puffs.php" class="btn">Acheter maintenant</a>
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

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const container = document.getElementById('modelContainer');
			const arTrigger = document.getElementById('arTrigger');

			// Détecter Android
			const android = /Android/.test(navigator.userAgent);

			if (android) {
				// Ajouter événement de clic pour Android
				arTrigger.addEventListener('click', function () {
					// Créer et insérer model-viewer uniquement après clic
					const modelViewer = document.createElement('model-viewer');
					modelViewer.src = "model/HU_EVO_RWD_06.glb";
					modelViewer.setAttribute("ar", "");
					modelViewer.setAttribute("ar-modes", "webxr scene-viewer");
					modelViewer.setAttribute("environment-image", "neutral");
					modelViewer.setAttribute("auto-rotate", "");
					modelViewer.setAttribute("camera-controls", "");
					modelViewer.setAttribute("poster", "image/lambo4.jpg");
					modelViewer.style.width = '100%';
					modelViewer.style.height = 'auto';
					modelViewer.alt = "Lamborghini Revuelto in AR";

					// Insérer model-viewer dans le DOM
					container.insertBefore(modelViewer, arTrigger.nextSibling);
					arTrigger.style.display = 'none'; // Cache l'image déclencheur
				});
			} else {
				// Configuration pour iOS et autres OS
				arTrigger.outerHTML = `
			<a rel="ar" href="model/HU_EVO_RWD_06.usdz">
				<img src="image/lambo4.jpg" alt="Voir en AR">
			</a>
		`;
			}
		});
	</script>
</body>

</html>