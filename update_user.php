<?php
include 'components/connection.php';
session_start();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
	header("location: login.php");
	exit;
}

$user_id = $_SESSION['user_id'];
$message = [];

// Gestion de la déconnexion
if (isset($_POST['logout'])) {
	session_destroy();
	header("location: login.php");
	exit; // Assurez-vous de terminer le script après la redirection
}

// Traitement du formulaire de mise à jour
if (isset($_POST['submit'])) {
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	// Mise à jour du nom d'utilisateur
	if (!empty($name) && $name !== $_SESSION['user_name']) {
		$update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
		$update_name->execute([$name, $user_id]);
		$_SESSION['user_name'] = $name; // Mise à jour de la session
	}

	// Mise à jour de l'email
	if (!empty($email) && $email !== $_SESSION['user_email'] && filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
		$update_email->execute([$email, $user_id]);
		$_SESSION['user_email'] = $email; // Mise à jour de la session
	}

	// Gestion de l'image de profil
	if (!empty($_FILES['image']['name'])) {
		$image = $_FILES['image']['name'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_folder = 'image/' . $image;
		move_uploaded_file($image_tmp_name, $image_folder);
		$_SESSION['user_profile'] = $image; // Mise à jour de la session
		$update_image = $conn->prepare("UPDATE `users` SET profile = ? WHERE id = ?");
		$update_image->execute([$image, $user_id]);
	}

	// Mise à jour du mot de passe
	if (!empty($_POST['old_pass']) && !empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])) {
		if ($_POST['new_pass'] !== $_POST['confirm_pass']) {
			$warning_msg[] = "Le nouveau mot de passe et la confirmation ne correspondent pas.";
		} else {
			$old_pass = $_POST['old_pass'];
			$select_old_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
			$select_old_pass->execute([$user_id]);
			$fetch_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);

			if ($old_pass === $fetch_pass['password']) {
				$new_pass = $_POST['new_pass'];
				$update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
				$update_pass->execute([$new_pass, $user_id]);
				$success_msg[] = 'Mot de passe mis à jour avec succès.';
			} else {
				$warning_msg[] = "L'ancien mot de passe ne correspond pas.";
			}
		}
	}
}
?>

<style>
	<?php include 'style.css'; ?>
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
	<title>Mettre à jour le profil - Road Luxury</title>
</head>

<body style="padding-left: 0 !important;">

	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Mettre à jour le profil</h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Mettre à jour le profil</span>
		</div>
		<section>
			<div class="form-container" id="users_login">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="profile">
						<?php
						// Affichage de l'image de profil ou d'une icône par défaut
						if (!empty($_SESSION['user_profile'])) {
							echo "<img src='image/" . $_SESSION['user_profile'] . "' class='profile-image' alt='Profile Image' width='100'>";
						} else {
							echo "<div class='user-icon-default'><i class='bx bxs-user'></i></div>";
						}
						?>
					</div>
					<h3>Mettre à jour le profil</h3>
					<div class="input-field">
						<label for="name">Nom d'utilisateur <sup>*</sup></label>
						<input type="text" id="name" name="name" maxlength="20"
							placeholder="Saisissez votre nom d'utilisateur" required
							value="<?= $_SESSION['user_name'] ?? ''; ?>">
					</div>
					<div class="input-field">
						<label for="email">Email de l'utilisateur <sup>*</sup></label>
						<input type="email" id="email" name="email" maxlength="50" placeholder="Saisissez votre email"
							required value="<?= $_SESSION['user_email'] ?? ''; ?>">
					</div>
					<div class="input-field">
						<label for="old_pass">Ancien mot de passe <sup>*</sup></label>
						<input type="password" id="old_pass" name="old_pass" maxlength="20"
							placeholder="Saisissez votre mot de passe actuel">
					</div>
					<div class="input-field">
						<label for="new_pass">Nouveau mot de passe <sup>*</sup></label>
						<input type="password" id="new_pass" name="new_pass" maxlength="20"
							placeholder="Saisissez votre nouveau mot de passe">
					</div>
					<div class="input-field">
						<label for="confirm_pass">Confirmer le mot de passe <sup>*</sup></label>
						<input type="password" id="confirm_pass" name="confirm_pass" maxlength="20"
							placeholder="Confirmez votre nouveau mot de passe">
					</div>
					<div class="input-field">
						<label for="image">Télécharger la photo de profil <sup>*</sup></label>
						<input type="file" id="image" name="image"
							accept="image/jpg, image/jpeg, image/png, image/webp">
					</div>
					<input type="submit" name="submit" value="Mettre à jour le profil" class="btn">
				</form>
			</div>
		</section>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>

</html>