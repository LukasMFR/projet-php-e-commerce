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

if (isset($_POST['submit-btn'])) {
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$phone = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
	$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
	$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);

	// Si user_id est vide, vous pouvez décider de le passer à NULL ou de le laisser vide
	$user_id = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

	$stmt = $conn->prepare("INSERT INTO message (user_id, name, email, subject, message, phone) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bindParam(1, $user_id);
	$stmt->bindParam(2, $name);
	$stmt->bindParam(3, $email);
	$stmt->bindParam(4, $subject);
	$stmt->bindParam(5, $message);
	$stmt->bindParam(6, $phone);

	if ($stmt->execute()) {
		echo '<p>Merci pour votre message. Nous vous contacterons bientôt.</p>';
	} else {
		echo '<p>Erreur lors de l\'envoi de votre message. Veuillez réessayer plus tard.</p>';
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
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="img/favicon-64.png">
	<title>Contact - Road Luxury</title>
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
		<div class="form-container">
			<form method="post">
				<div class="title">
					<img src="img/download.png" class="logo">
					<h1>Laissez un message</h1>
				</div>
				<div class="input-field">
					<p>Votre nom <sup>*</sup></p>
					<input type="text" name="name" required>
				</div>
				<div class="input-field">
					<p>Votre email <sup>*</sup></p>
					<input type="email" name="email" required>
				</div>
				<div class="input-field">
					<p>Votre numéro <sup>*</sup></p>
					<input type="text" name="number">
				</div>
				<div class="input-field">
					<p>Sujet <sup>*</sup></p>
					<input type="text" name="subject" required placeholder="Entrez le sujet de votre message">
				</div>
				<div class="input-field">
					<p>Votre message <sup>*</sup></p>
					<textarea name="message" required></textarea>
				</div>
				<button type="submit" name="submit-btn" class="btn">Envoyer le message</button>
			</form>
		</div>

		<div class="address">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Détails de contact</h1>
				<p>Nous sommes là pour répondre à toutes vos questions. N'hésitez pas à nous contacter par mail,
					téléphone ou via le formulaire.</p>
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
						<p>contact@roadluxury.com</p>
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