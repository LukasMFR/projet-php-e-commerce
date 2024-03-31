<?php 
 include 'components/connection.php';
 session_start();
 if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	}else{
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
	<title>Page d'accueil - AutoCar</title>
</head>
<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		
		<section class="home-section">
			<div class="slider">
				<div class="slider__slider slide1">
					<div class="overlay"></div>
					<div class="slide-detail">
						<h1>Découvrez la nouvelle ère de la conduite</h1>
						<p>Plongez dans l'innovation avec notre dernière gamme de véhicules électriques. Performance, durabilité et design futuriste réunis.</p>
						<a href="view_products.php" class="btn">Achetez maintenant</a>
					</div>
					<div class="hero-dec-top"></div>
					<div class="hero-dec-bottom"></div>
				</div>
				<!-- slide end -->
				<div class="slider__slider slide2">
					<div class="overlay"></div>
					<div class="slide-detail">
						<h1>Élégance et puissance</h1>
						<p>Faites l'expérience du luxe ultime avec nos modèles premium. Un mélange parfait de confort, de style et de puissance.</p>
						<a href="view_products.php" class="btn">Achetez maintenant</a>
					</div>
					<div class="hero-dec-top"></div>
					<div class="hero-dec-bottom"></div>
				</div>
				<!-- slide end -->
				<div class="slider__slider slide3">
					<div class="overlay"></div>
					<div class="slide-detail">
						<h1>Aventure sans limites</h1>
						<p>Nos SUVs tout-terrain sont prêts à vous emmener sur tous les chemins. Explorez le monde avec confiance et confort.</p>
						<a href="view_products.php" class="btn">Achetez maintenant</a>
					</div>
					<div class="hero-dec-top"></div>
					<div class="hero-dec-bottom"></div>
				</div>
				<!-- slide end -->
				<div class="slider__slider slide4">
					<div class="overlay"></div>
					<div class="slide-detail">
						<h1>Sportivité et performance</h1>
						<p>Design aerodynamique, moteurs puissants et technologies de pointe pour une expérience de conduite exaltante.</p>
						<a href="view_products.php" class="btn">Achetez maintenant</a>
					</div>
					<div class="hero-dec-top"></div>
					<div class="hero-dec-bottom"></div>
				</div>
				<!-- slide end -->
				<div class="slider__slider slide5">
					<div class="overlay"></div>
					<div class="slide-detail">
						<h1>Éco-responsabilité au volant</h1>
						<p>Engagez-vous pour un avenir plus vert avec nos véhicules hybrides et électriques. Économie de carburant, réduction des émissions et conduite silencieuse.</p>
						<a href="view_products.php" class="btn">Achetez maintenant</a>
					</div>
					<div class="hero-dec-top"></div>
					<div class="hero-dec-bottom"></div>
				</div>
				<!-- slide end -->
				<div class="left-arrow"><i class='bx bxs-left-arrow'></i></div>
                <div class="right-arrow"><i class='bx bxs-right-arrow'></i></div>
			</div>
		</section>
		<!-- home slider end -->
		<section class="thumb">
			<div class="box-container">
				<div class="box">
					<img src="img/thumb2.jpg">
					<h3>Lamborghini</h3>
					<p>Découvrez le summum de la performance et du design italien avec nos modèles Lamborghini. Vivez l'expérience ultime de conduite sportive.</p>
					<i class="bx bx-chevron-right"></i>
				</div>
				<div class="box">
					<img src="img/thumb0.jpg">
					<h3>Porsche</h3>
					<p>Élégance, puissance et innovation : les Porsche incarnent l'excellence allemande. Explorez la sélection pour trouver votre prochaine voiture de sport.</p>
					<i class="bx bx-chevron-right"></i>
				</div>
				<div class="box">
					<img src="img/thumb1.jpg">
					<h3>Ferrari</h3>
					<p>Plongez dans le monde de Ferrari, synonyme de passion, de prestige et de performances pures. Choisissez la Ferrari qui fait battre votre cœur.</p>
					<i class="bx bx-chevron-right"></i>
				</div>
				<div class="box">
					<img src="img/thumb.jpg">
					<h3>Alpine</h3>
					<p>L'Alpine combine agilité et style français dans une voiture sportive unique. Découvrez notre gamme pour une expérience de conduite exceptionnelle.</p>
					<i class="bx bx-chevron-right"></i>
				</div>
			</div>
		</section>
		<section class="container">
			<div class="box-container">
				<div class="box">
					<!--chnager limage-->
					<img src="img/about-us.jpg">
				</div>
				<div class="box">
					<img src="img/download.png">
					<span>AutoCar</span>
					<h1>Économisez jusqu'à 50 %</h1>
					<p>Découvrez notre gamme de véhicules à des prix jamais vus. L'occasion parfaite pour acquérir la voiture de vos rêves à moindre coût.</p>
				</div>
			</div>
		</section>
		<section class="shop">
			<div class="title">
				<img src="img/download.png">
				<h1>Produits tendance</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="img/card.jpg">
					<a href="view_products.php" class="btn">Achetez maintenant</a>
				</div>
				<div class="box">
					<img src="img/card0.jpg">
					<a href="view_products.php" class="btn">Achetez maintenant</a>
				</div>
				<div class="box">
					<img src="img/card1.jpg">
					<a href="view_products.php" class="btn">Achetez maintenant</a>
				</div>
			</div>
			<div class="title">
				<img src="img/download.png">
				<h1>Nouvelle arivage</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="img/card.jpg">
					<a href="view_products.php" class="btn">Achetez maintenant</a>
				</div>
				<div class="box">
					<img src="img/card0.jpg">
					<a href="view_products.php" class="btn">Achetez maintenant</a>
				</div>
				<div class="box">
					<img src="img/card1.jpg">
					<a href="view_products.php" class="btn">Achetez maintenant</a>
				</div>
			
		</section>
		<section class="shop-category">
		<div class="title">
				<img src="img/download.png">
				<h1>Game de Puff</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<img src="img/6.jpg">
					<div class="detail">
						<span>GROSSES PROMOTIONS</span>
						<h1>Sur une large sélection de puffs</h1>
						<a href="view_products.php" class="btn">Achetez maintenant</a>
					</div>
				</div>
				<div class="box">
					<img src="img/7.jpg">
					<div class="detail">
						<span>Nouveaux goûts</span>
						<h1>Testez notre puff goût essence !</h1>
						<a href="view_products.php" class="btn">Achetez maintenant</a>
					</div>
				</div>
			</div>
		</section>
		<section class="services">
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
		<section class="brand">
			<div class="box-container">
				<div class="box">
					<img src="img/brand (1).jpg">
				</div>
				<div class="box">
					<img src="img/brand (2).jpg">
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
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>