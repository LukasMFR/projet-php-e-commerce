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
	<title>Contact - AutoCar</title>
</head>
<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Nous contacter</h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Nous contacter</span>
		</div>
		<!-- <section class="services">
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
		</section> -->
		<div class="form-container">
			 <form method="post">
			 	<div class="title">
			 		<img src="img/download.png" class="logo">
			 		<h1>Laissez un message</h1>
			 	</div>
			 	<div class="input-field">
			 		<p>Votre nom <sup>*</sup></p>
			 		<input type="text" name="name">
			 	</div>
			 	<div class="input-field">
			 		<p>Votre email <sup>*</sup></p>
			 		<input type="email" name="email">
			 	</div>
			 	<div class="input-field">
			 		<p>Votre numéro <sup>*</sup></p>
			 		<input type="text" name="number">
			 	</div>
			 	<div class="input-field">
			 		<p>Votre message <sup>*</sup></p>
			 		<textarea name="message"></textarea>
			 	</div>
			 	<button type="submit" name="submit-btn" class="btn">Envoyer le message</button>
			 </form>
			 
		</div>
		<div class="address">
			 	<div class="title">
			 		<img src="img/download.png" class="logo">
			 		<h1>Détails de contact</h1>
			 		<p>Nous sommes là pour répondre à toutes vos questions. N'hésitez pas à nous contacter par mail, téléphone ou via le formulaire.</p>
			 	</div>
			 	<div class="box-container">
			 		<div class="box">
			 			<i class="bx bxs-map-pin"></i>
			 			<div>
			 				<h4>Adresse</h4>
			 				<p>10 Rue de Rivoli, 75001 Paris</p>
			 			</div>
			 		</div>
			 		<div class="box">
			 			<i class="bx bxs-phone-call"></i>
			 			<div>
			 				<h4>Numéro de téléphone</h4>
			 				<p>+33 6 12 34 56 78</p>
			 			</div>
			 		</div>
			 		<div class="box">
			 			<i class="bx bxs-map-pin"></i>
			 			<div>
			 				<h4>Email</h4>
			 				<p>contact@autocar.com</p>
			 			</div>
			 		</div>
			 	</div>
			 </div>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>