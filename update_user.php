<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include 'components/connection.php';
session_start();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
	header("location: login.php");
	exit;
}

$user_id = $_SESSION['user_id'];

// Gestion de la déconnexion
if (isset($_POST['logout'])) {
	session_destroy();
	header("location: login.php");
	exit; // Assurez-vous de terminer le script après la redirection
}

// Gestion de la suppression de l'image de profil
if (isset($_POST['delete_image'])) {
	$select_image = $conn->prepare("SELECT profile_pic FROM `users` WHERE id = ?");
	$select_image->execute([$user_id]);
	$row = $select_image->fetch(PDO::FETCH_ASSOC);
	$current_image = $row['profile_pic'];

	if ($current_image) {
		// Supprimez l'image du dossier
		if (file_exists($current_image)) {
			unlink($current_image);
		}

		// Mettez à jour la base de données pour supprimer le chemin de l'image
		$update_image = $conn->prepare("UPDATE `users` SET profile_pic = NULL WHERE id = ?");
		$update_image->execute([$user_id]);

		// Mettez à jour la variable de session
		$_SESSION['user_profile'] = null;

		// Message de confirmation
		echo "<p>Photo de profil supprimée avec succès.</p>";
	} else {
		echo "<p>Aucune photo de profil à supprimer.</p>";
	}
}

// Traitement du formulaire de mise à jour
if (isset($_POST['submit'])) {
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	// Mise à jour du nom d'utilisateur
	if (!empty($name) && $name !== $_SESSION['user_name']) {
		$update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
		$update_name->execute([$name, $user_id]);
		$_SESSION['user_name'] = $name;
	}

	// Mise à jour de l'email
	if (!empty($email) && $email !== $_SESSION['user_email'] && filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
		$update_email->execute([$email, $user_id]);
		$_SESSION['user_email'] = $email;
	}

	// Gestion de l'image de profil
	if (!empty($_FILES['image']['name'])) {
		$image_name = $_FILES['image']['name'];
		$image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
		$new_image_name = $user_id . '_' . time() . '.' . $image_ext; // Crée un nom unique pour l'image
		$image_folder = 'user_profile_images/' . $new_image_name; // Dossier et nom de fichier final
		if (move_uploaded_file($_FILES['image']['tmp_name'], $image_folder)) {
			$_SESSION['user_profile'] = $image_folder; // Mise à jour de la session avec le chemin de l'image
			$update_image = $conn->prepare("UPDATE `users` SET profile_pic = ? WHERE id = ?");
			$update_image->execute([$image_folder, $user_id]);
			$success_msg[] = 'Image mise à jour avec succès.';
		} else {
			$error_msg[] = "Erreur lors du téléchargement de l'image.";
		}
	}

	// Gestion de l'image de profil
	if (!empty($_FILES['new_profile_image']['name'])) {
		// Récupère les détails du fichier téléchargé
		$image_name = $_FILES['new_profile_image']['name'];
		$image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
		$new_image_name = $user_id . '_' . time() . '.' . $image_ext; // Crée un nom unique pour l'image
		$image_folder = 'user_profile_images/' . $new_image_name; // Dossier et nom de fichier final

		// Déplace le fichier téléchargé vers le répertoire final
		if (move_uploaded_file($_FILES['new_profile_image']['tmp_name'], $image_folder)) {
			// Met à jour la session avec le chemin de l'image
			$_SESSION['user_profile'] = $image_folder;

			// Met à jour la base de données avec le nouveau chemin de l'image
			$update_image = $conn->prepare("UPDATE `users` SET profile_pic = ? WHERE id = ?");
			$update_image->execute([$image_folder, $user_id]);

			$success_msg[] = 'Image mise à jour avec succès.';
		} else {
			$error_msg[] = "Erreur lors du téléchargement de l'image.";
		}
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<title>Mettre à jour le profil - Road Luxury</title>
	<script>
		function previewFile() {
			const file = document.querySelector('input[type=file]').files[0];
			const preview = document.getElementById('profile-preview');
			const fileNameDisplay = document.getElementById('file-name');

			if (file) {
				const reader = new FileReader();

				reader.onloadend = function () {
					if (preview.tagName === 'IMG') { // Assure que la prévisualisation fonctionne si c'est une balise img
						preview.src = reader.result;
					} else { // Crée une nouvelle img si l'icône par défaut est utilisée
						const img = document.createElement('img');
						img.src = reader.result;
						img.classList.add('profile-image');
						img.alt = 'Profile Image';
						img.width = 100;
						preview.parentNode.replaceChild(img, preview); // Remplace l'icône par l'image
					}
				}

				if (file) {
					reader.readAsDataURL(file);
					fileNameDisplay.textContent = file.name; // Affiche le nom du fichier
				} else {
					preview.src = "";
					fileNameDisplay.textContent = "";
				}
			}
		}
	</script>

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
		<section class="update-profile">
			<div class="form-container" id="users_login">
				<form action="" method="post" enctype="multipart/form-data">
					<!-- Premier conteneur : image et nom/email -->
					<div class="profile-container">
						<div class="image-container">
							<label for="new_profile_image" class="image-upload-label">
								<?php
								if (!empty($_SESSION['user_profile'])) {
									echo "<img id='profile-preview' src='" . $_SESSION['user_profile'] . "' class='profile-image' alt='Profile Image' width='100'>";
								} else {
									echo "<div id='profile-preview' class='user-icon-default'><i class='bx bxs-user'></i></div>";
								}
								?>
								<input type="file" id="new_profile_image" name="new_profile_image" accept="image/*"
									style="display: none;" onchange="previewFile();">
								<div class="overlay"><i class="fa-solid fa-pen"></i></div>
							</label>
							<span id="file-name" class="file-name"></span>
							<input type="submit" name="delete_image" value="Supprimer la photo de profil"
								class="btn delete-photo-btn">
						</div>
						<div class="info-container">
							<h3>Mettre à jour le profil</h3>
							<div class="input-field">
								<label for="name">Nom d'utilisateur <sup>*</sup></label>
								<input type="text" id="name" name="name" maxlength="255"
									placeholder="Saisissez votre nom d'utilisateur" required
									value="<?= $_SESSION['user_name'] ?? ''; ?>">
							</div>
							<div class="input-field">
								<label for="email">Email de l'utilisateur <sup>*</sup></label>
								<input type="email" id="email" name="email" maxlength="255"
									placeholder="Saisissez votre email" required
									value="<?= $_SESSION['user_email'] ?? ''; ?>">
							</div>
						</div>
					</div>
					<!-- Deuxième conteneur : reste du formulaire -->
					<div class="additional-fields">
						<div class="input-field">
							<label for="old_pass">Ancien mot de passe <sup>*</sup></label>
							<input type="password" id="old_pass" name="old_pass" maxlength="255"
								placeholder="Saisissez votre mot de passe actuel">
						</div>
						<div class="input-field">
							<label for="new_pass">Nouveau mot de passe <sup>*</sup></label>
							<input type="password" id="new_pass" name="new_pass" maxlength="255"
								placeholder="Saisissez votre nouveau mot de passe">
						</div>
						<div class="input-field">
							<label for="confirm_pass">Confirmer le mot de passe <sup>*</sup></label>
							<input type="password" id="confirm_pass" name="confirm_pass" maxlength="255"
								placeholder="Confirmez votre nouveau mot de passe">
						</div>
						<div class="input-field">
							<label for="image">Télécharger la photo de profil <sup>*</sup></label>
							<input type="file" id="image" name="image" accept="image/jpeg, image/png">
						</div>

						<div class="button-container">
							<!-- <input type="submit" name="delete_image" value="Supprimer la photo de profil" class="btn"> -->
							<input type="submit" name="submit" value="Mettre à jour le profil" class="btn">
						</div>
					</div>
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