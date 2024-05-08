<?php
include 'components/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
} else {
	$user_id = '';
}

//register user
if (isset($_POST['submit'])) {
	$id = unique_id();
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
	$cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

	$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
	$select_user->execute([$email]);

	if ($select_user->rowCount() > 0) {
		$warning_msg[] = 'Email déjà existant';
	} else {
		if ($pass !== $cpass) {
			$warning_msg[] = 'Les mots de passe ne correspondent pas';
		} else {
			$insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password) VALUES(?, ?, ?, ?)");
			$insert_user->execute([$id, $name, $email, $pass]);
			$_SESSION['user_id'] = $id;
			$_SESSION['user_name'] = $name;
			$_SESSION['user_email'] = $email;
			$_SESSION['success_msg'] = 'Votre compte a été créé avec succès ! Bienvenue ' . $name . '.';
			header('location: home.php');
			exit;
		}
	}
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
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="img/favicon-64.png">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>S'enregistrer - Road Luxury</title>
</head>

<body>
	<div class="main-container">
		<section class="home-section">
			<div class="video-container">
				<video autoplay loop muted playsinline>
					<source src="image/videoPres2.mp4" type="video/mp4">
				</video>
				<div class="overlay"></div>
				<div class="video-detail">
					<h1>Bienvenue chez Road Luxury</h1>
					<p>L'art de l'élégance automobile.</p>
				</div>
			</div>
		</section>
		<section class="form-container">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Inscrivez-vous</h1>
				<p>Rejoignez notre communauté dès aujourd'hui et bénéficiez d'avantages exclusifs. Commencez votre
					expérience unique avec nous.</p>
			</div>
			<form action="" method="post">
				<div class="input-field">
					<p>Votre nom <sup>*</sup></p>
					<input type="text" name="name" required placeholder="Entrez votre nom" maxlength="50">
				</div>
				<div class="input-field">
					<p>Votre email <sup>*</sup></p>
					<input type="email" name="email" required placeholder="Entrez votre email" maxlength="50"
						oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				<div class="input-field">
					<p>Votre mot de passe <sup>*</sup></p>
					<input type="password" name="pass" required placeholder="Entrez votre mot de passe" maxlength="50"
						oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				<div class="input-field">
					<p>Confirmez le mot de passe <sup>*</sup></p>
					<input type="password" name="cpass" required placeholder="Entrez votre mot de passe" maxlength="50"
						oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				<input type="submit" name="submit" value="S'enregistrer" class="btn">
				<p class="account-invitation">Vous avez déjà un compte ? <a href="login.php">Connectez-vous
						maintenant</a></p>
				<!-- Lien Retour vers la page d'accueil -->
				<a href="home.php" class="btn">Retour à l'accueil</a>
			</form>
		</section>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>

</html>