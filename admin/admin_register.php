<?php
include '../components/connection.php';

if (isset($_POST['submit'])) {
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$password = sha1($_POST['password']);
	$cpassword = sha1($_POST['cpassword']);

	$image = $_FILES['image']['name'];
	$image = filter_var($image, FILTER_SANITIZE_STRING);
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image_folder = '../image/' . $image;

	$select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
	$select_admin->execute([$name]);

	if ($select_admin->rowCount() > 0) {
		$message[] = 'Le nom d\'utilisateur existe déjà !';
	} else {
		if ($password != $cpassword) {
			$warning_msg[] = 'Le mot de passe de confirmation ne correspond pas !';
		} else {
			$insert_admin = $conn->prepare("INSERT INTO `admin`(name, email, password, profile) VALUES(?,?,?,?)");
			$insert_admin->execute([$name, $email, $password, $image]);
			move_uploaded_file($image_tmp_name, $image_folder);
			$success_msg[] = 'Nouvel administrateur enregistré !';
		}
	}
}

?>
<style>
	<?php include 'admin_style.css'; ?>
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
	<?php include '../components/pwa-setup.php'; ?>
</head>

<body style="padding-left: 0 !important;">

	<div class="main-container">


		<section>

			<div class="form-container" id="admin_login">
				<form action="" method="post" enctype="multipart/form-data">
					<h3>S'enregistrer</h3>
					<div class="input-field">
						<label>Nom d'utilisateur <sup>*</sup></label>
						<input type="text" name="name" maxlength="255" required
							placeholder="Saisir votre nom d'utilisateur">
					</div>
					<div class="input-field">
						<label>Email <sup>*</sup></label>
						<input type="email" name="email" maxlength="255" required placeholder="Saisir votre email">
					</div>
					<div class="input-field">
						<label>Mot de passe <sup>*</sup></label>
						<input type="password" name="password" required placeholder="Saisir votre mot de passe">
					</div>
					<div class="input-field">
						<label>Confirmer le mot de passe <sup>*</sup></label>
						<input type="password" name="cpassword" required placeholder="Confirmer votre mot de passe">
					</div>
					<div class="input-field">
						<label>Télécharger la photo de profil <sup>*</sup></label>
						<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">
					</div>
					<input type="submit" name="submit" value="S'inscrire" class="btn">
					<p>Vous avez déjà un compte ? <a href="admin_login.php">Connectez-vous maintenant</a></p>
				</form>
			</div>
		</section>
	</div>
	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="script.js"></script>

	<?php include '../components/alert.php'; ?>
</body>

</html>