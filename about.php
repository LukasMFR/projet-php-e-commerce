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
	<title>À propos - Road Luxury</title>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner about">
			<!-- <h1>À propos de nous</h1> -->
		</div>
		<div class="title2">
			<a href="home.php">accueil </a><span>/ à propos</span>
		</div>

		
		<section class="thumb">
					<div class="box-container">
						<div class="box">
							<img src="img/logo-lamborghini.png">
							<h3>Lamborghini</h3>
							<p>Découvrez le summum de la performance et du design italien avec nos modèles Lamborghini. Vivez
								l'expérience ultime de conduite sportive.</p>
							<i class="bx bx-chevron-right"></i>
						</div>
						<div class="box">
							<img src="img/logo-porsche.png">
							<h3>Porsche</h3>
							<p>Élégance, puissance et innovation : les Porsche incarnent l'excellence allemande. Explorez la
								sélection pour trouver votre prochaine voiture de sport.</p>
							<i class="bx bx-chevron-right"></i>
						</div>
						<div class="box">
							<img src="img/logo-ferrari-bw.png">
							<h3>Ferrari</h3>
							<p>Plongez dans le monde de Ferrari, synonyme de passion, de prestige et de performances pures.
								Choisissez la Ferrari qui fait battre votre cœur.</p>
							<i class="bx bx-chevron-right"></i>
						</div>
						<div class="box">
							<img src="img/logo-alpine.png">
							<h3>Alpine</h3>
							<p>L'Alpine combine agilité et style français dans une voiture sportive unique. Découvrez notre
								gamme pour une expérience de conduite exceptionnelle.</p>
							<i class="bx bx-chevron-right"></i>
						</div>
						
						
					</div>
				</section>


		<div class="about">
			<div class="row">
				<div class="img-box">
					<img src="img/3.png">
				</div>
				<div class="detail">
					<h1>Notre mission</h1>
					<p>Notre mission est de fournir les meilleures solutions de location de voitures de luxe et de services, 
						en mettant l'accent sur l'exclusivité pour vos vacances ou votre expérience professionnelle. 
						Nous combinons nos propres connaissances et expériences avec une large gamme d'options de location de 
						voitures de luxe sur mesure pour offrir la solution idéale a chaque client. Notre objectif est de fournir un 
						service abordable qui répond et dépasse les attentes du client, et nous ne sommes satisfaits que si le client 
						est satisfait. Louez votre voiture de luxe chez nous pour être sur la bonne voie !</p>
					<a href="view_products.php" class="btn">Acheter maintenant</a>
				</div>
			</div>
		</div>
		

		<div class="testimonial-container">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Ce que nos clients disent de nous</h1>
				<p>Leur satisfaction, notre réussite.</p>
			</div>
			<div class="container">
				<div class="testimonial-item active">
					<img src="img/01.jpg">
					<h1>Emma Leroux</h1>
					<p>Achat d'une Peugeot 308 - une expérience sans faute du début à la fin. Conseils experts et
						service clientèle au top.</p>
				</div>
				<div class="testimonial-item">
					<img src="img/02.jpg">
					<h1>Thomas Girard</h1>
					<p>J'ai acheté une Renault Clio récemment, et je suis plus que satisfaite. La voiture est parfaite
						et le processus d'achat a été fluide et agréable.</p>
				</div>
				<div class="testimonial-item">
					<img src="img/03.jpg">
					<h1>Chloé Petit</h1>
					<p>J'ai opté pour un pack voiture + puffs pour ma nouvelle Citroën C3. Non seulement la voiture est
						incroyable, mais les puffs ajoutent une touche unique à mon intérieur.</p>
				</div>
				<div class="testimonial-item">
					<img src="img/04.png">
					<h1>Marie Dubois</h1>
					<p>Incroyable expérience chez vous ! La Tesla Model 3 est un rêve devenu réalité, et les puffs
						personnalisés la rendent encore plus spéciale. Merci pour tout !</p>
				</div>
				<div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
				<div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
			</div>
		</div>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<script type="text/javascript">
		let slides = document.querySelectorAll('.testimonial-item');
		let index = 0;

		function nextSlide() {
			slides[index].classList.remove('active');
			index = (index + 1) % slides.length;
			slides[index].classList.add('active');
		}
		function prevSlide() {
			slides[index].classList.remove('active');
			index = (index - 1 + slides.length) % slides.length;
			slides[index].classList.add('active');
		}
	</script>
	<?php include 'components/alert.php'; ?>
</body>

</html>