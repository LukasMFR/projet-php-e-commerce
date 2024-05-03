<?php
include '../components/connection.php';
session_start();

$users_id = $_SESSION['users_id'];

if (!isset($users_id)) {
	header('location: login.php');
}

if (isset($_POST['submit'])) {

	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

	// Mise à jour du nom
	if (!empty($name)) {
		$select_name = $conn->prepare("SELECT * FROM `users` WHERE name = ? AND id != ?");
		$select_name->execute([$name, $users_id]);
		if ($select_name->rowCount() > 0) {
			$message[] = 'Nom d\'utilisateur déjà pris !';
		} else {
			$update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
			$update_name->execute([$name, $users_id]);
		}
	}

	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	// Mise à jour de l'email
	if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND id != ?");
		$select_email->execute([$email, $users_id]);
		if ($select_email->rowCount() > 0) {
			$message[] = 'Email déjà pris !';
		} else {
			$update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
			$update_email->execute([$email, $users_id]);
		}
	}

	// Mise à jour de l'image de profil
	$image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
	$image_tmp_name = $_FILES['image']['tmp_name'];
	if (!empty($image)) {
		$image_folder = '../image/' . $image;
		$update_image = $conn->prepare("UPDATE `users` SET profile = ? WHERE id = ?");
		$update_image->execute([$image, $users_id]);
		move_uploaded_file($image_tmp_name, $image_folder);
		if (!empty($old_image) && $old_image != $image) {
			unlink('../image/' . $old_image);
		}
		$message[] = 'Profil mis à jour !';
	}

	// Mise à jour du mot de passe
	$old_pass = sha1($_POST['old_pass']);
	$new_pass = sha1($_POST['new_pass']);
	$confirm_pass = sha1($_POST['confirm_pass']);

	$select_old_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
	$select_old_pass->execute([$users_id]);
	$prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC)['password'];

	if ($old_pass != $prev_pass) {
		$message[] = 'L\'ancien mot de passe ne correspond pas';
	} elseif ($new_pass != $confirm_pass) {
		$message[] = 'Le mot de passe de confirmation ne correspond pas';
	} else {
		$update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
		$update_pass->execute([$confirm_pass, $users_id]);
		$message[] = 'Mot de passe mis à jour avec succès';
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

	<?php include '../components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Mettre à jour le profil</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Accueil </a><span>/ Mettre à jour le profil</span>
		</div>
		<section>
			<?php
			if (isset($message)) {
				foreach ($message as $msg) {
					echo '<div class="message"><span>' . $msg . '</span><i class="bx bx-x" onclick="this.parentElement.remove();"></i></div>';
				}
			}
			?>
			<div class="form-container" id="users_login">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="profile">
						<img src="../image/<?= $fetch_profile['profile']; ?>" class="logo-image" width="100">
					</div>
					<h3>Mettre à jour le profil</h3>
					<input type="hidden" name="old_image" value="<?= $fetch_profile['profile']; ?>">
					<div class="input-field">
						<label>Nom d'utilisateur <sup>*</sup></label>
						<input type="text" name="name" maxlength="20" placeholder="Saisissez votre nom d'utilisateur"
							oninput="this.value = this.value.replace(/\s+/g, '')"
							value="<?= $fetch_profile['name']; ?>">
					</div>
					<div class="input-field">
						<label>Email de l'utilisateur <sup>*</sup></label>
						<input type="email" name="email" maxlength="50" placeholder="Saisissez votre email"
							oninput="this.value = this.value.replace(/\s+/g, '')"
							value="<?= $fetch_profile['email']; ?>">
					</div>
					<div class="input-field">
						<label>Ancien mot de passe <sup>*</sup></label>
						<input type="password" name="old_pass" maxlength="20"
							placeholder="Saisissez votre mot de passe actuel">
					</div>
					<div class="input-field">
						<label>Nouveau mot de passe <sup>*</sup></label>
						<input type="password" name="new_pass" maxlength="20"
							placeholder="Saisissez votre nouveau mot de passe">
					</div>
					<div class="input-field">
						<label>Confirmer le mot de passe <sup>*</sup></label>
						<input type="password" name="confirm_pass" maxlength="20"
							placeholder="Confirmez votre nouveau mot de passe">
					</div>
					<div class="input-field">
						<label>Télécharger la photo de profil <sup>*</sup></label>
						<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">
					</div>
					<input type="submit" name="submit" value="Mettre à jour le profil" class="btn">
				</form>
			</div>
		</section>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include '../components/alert.php'; ?>
</body>

</html>