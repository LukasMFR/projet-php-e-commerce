<?php
include 'components/connection.php';
session_start();

if (isset($_POST['submit'])) {
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

	// Prepare and execute the SQL statement
	$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
	$select_user->execute([$email, $pass]);
	$row = $select_user->fetch(PDO::FETCH_ASSOC);

	if ($select_user->rowCount() > 0) {
		// Set session variables upon successful login
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['user_name'] = $row['name'];
		$_SESSION['user_email'] = $row['email'];
		$_SESSION['welcome_login'] = true;
		header('location: order.php');
	} else {
		$warning_msg[] = 'Identifiant ou mot de passe incorrect';
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
	<title>Se connecter - Road Luxury</title>
</head>

<body>
	<div class="main-container">
		<section class="form-container">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Connectez-vous</h1>
				<p>Accédez à votre compte pour une expérience personnalisée. Profitez de nos services exclusifs en vous
					connectant dès maintenant.</p>
			</div>
			<form action="" method="post">
				<div class="input-field">
					<p>Votre email <sup>*</sup></p>
					<input type="email" name="email" required placeholder="Saisissez votre email" maxlength="50"
						oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				<div class="input-field">
					<p>Votre mot de passe <sup>*</sup></p>
					<input type="password" name="pass" required placeholder="Saisissez votre mot de passe"
						maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
				</div>

				<input type="submit" name="submit" value="Se connecter" class="btn">
				<p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous maintenant</a></p>
				<!-- Lien Retour vers la page d'accueil -->
				<a href="home.php" class="btn">Retour à l'accueil</a>
			</form>
		</section>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<?php include 'components/alert.php'; ?>
</body>

</html>