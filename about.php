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

		<div class="about">
			<div class="row">
				<div class="img-box">
					<img src="img/3.png">
				</div>
				<div class="detail">
					<h1>Notre mission</h1>
					<p>Notre mission est de fournir les meilleures solutions de vente de voitures de luxe et de
						services, en mettant l'accent sur l'exclusivité pour vos vacances ou votre expérience
						professionnelle. Nous combinons nos propres connaissances et expériences avec une vaste
						sélection de voitures de luxe sur mesure pour offrir la solution idéale à chaque client. Notre
						objectif est de fournir un service abordable qui répond et dépasse les attentes du client, et
						nous ne sommes satisfaits que si le client l'est également. Achetez votre voiture de luxe chez
						nous pour être sûr d'être sur la bonne voie !</p>
					<a href="view_products.php" class="btn">Acheter maintenant</a>
				</div>
			</div>
		</div>

		<h2 class="section-title">Les employés</h2>
		<div class="about-section">
			<div class="profile">
				<img src="img/anis.jpg" alt="Anis Fetouab">
				<div class="name">Anis Fetouab</div>
				<div class="role">Product Owner</div>
			</div>
			<div class="profile">
				<img src="img/hillel.jpg" alt="Hillel Ohayon">
				<div class="name">Hillel Ohayon</div>
				<div class="role">CEO</div>
			</div>
			<div class="profile">
				<img src="img/lukas.jpg" alt="Lukas Mauffré">
				<div class="name">Lukas Mauffré</div>
				<div class="role">Co-Fondateur</div>
			</div>
			<div class="profile">
				<img src="img/PHOTO-2024-05-15-14-00-06.jpg" alt="Maximilien Gilbert">
				<div class="name">Maximilien Gilbert</div>
				<div class="role">Commercial</div>
			</div>
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


		<div class="testimonial-container">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Ce que nos clients disent de nous</h1>
				<p>Leur satisfaction, notre réussite.</p>
			</div>
			<div class="container">
				<div class="testimonial-item active">
					<img src="img/01.jpg">
					<h1>Emma Leroux - Lamborghini Urus & Puff Sans Plomb 95</h1>
					<h1 class="rating">★★★★★ 5/5</h1>
					<p>"J'ai récemment fait l'acquisition d'une Lamborghini Urus et d'un Puff Sans Plomb 95.
						L'expérience a été exceptionnelle du début à la fin. L'Urus allie luxe et performance de manière
						spectaculaire, offrant un confort sans pareil et une conduite excitante. Quant au Puff Sans
						Plomb 95, il offre une expérience de vapotage douce et agréable, ce qui en fait le compagnon
						parfait pour les longs trajets. Je suis extrêmement satisfait de ces achats et du service client
						de Road Luxury."</p>
				</div>
				<div class="testimonial-item">
					<img src="img/02.jpg">
					<h1>Thomas Girard - Alpine A110 R & Puff Gazole</h1>
					<h1 class="rating">★★★★☆ 4/5</h1>
					<p>"Acheter une Alpine A110 R et un Puff Gazole a été une aventure fascinante. L'Alpine
						est agile et dynamique, parfaite pour s'évader sur les routes de campagne. Le Puff Gazole, bien
						que très particulier avec son arôme robuste, rappelle l'odeur des garages et des longues
						journées de conduite. C'est une combinaison idéale pour ceux qui cherchent à mélanger tradition
						et modernité dans leurs loisirs."</p>
				</div>
				<div class="testimonial-item">
					<img src="img/03.jpg">
					<h1>Chloé Petit - Bugatti La Voiture Noire</h1>
					<h1 class="rating">★★★★★ 5/5</h1>
					<p>"La Bugatti La Voiture Noire est un rêve devenu réalité. Chaque détail est
						impeccablement conçu, offrant une expérience de luxe ultime. La performance est inégalée, et
						conduire cette merveille est comme piloter un avion de chasse sur la route. C'est bien plus
						qu'une voiture; c'est une déclaration de prestige et de sophistication."</p>
				</div>
				<div class="testimonial-item">
					<img src="img/04.png">
					<h1>Marie Dubois - Puff Superéthanol E85</h1>
					<h1 class="rating">★★★★☆ 4/5</h1>
					<p>"Le Puff Superéthanol E85 est une véritable surprise. Avec son arôme énergique et un
						peu audacieux, il offre une expérience unique qui est à la fois revigorante et amusante. C'est
						un excellent choix pour ceux qui cherchent à sortir de l'ordinaire et à expérimenter quelque
						chose de nouveau et d'excitant dans leur routine de vapotage."</p>
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