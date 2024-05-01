<?php
include '../components/connection.php';

session_start();

if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$name = filter_var($name, FILTER_SANITIZE_STRING);

	// Le mot de passe est haché avec SHA1 (non recommandé pour les environnements de production)
	$pass = sha1($_POST['password']);
	$pass = filter_var($pass, FILTER_SANITIZE_STRING);

	// Modification de la requête pour correspondre aux champs de la nouvelle table `admin`
	$select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
	$select_admin->execute([$name, $pass]);

	if ($select_admin->rowCount() > 0) {
		$fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
		$_SESSION['admin_id'] = $fetch_admin['id'];
		header('location:dashboard.php');
		exit();  // Il est bon d'ajouter exit après un header location pour éviter d'exécuter du code supplémentaire
	} else {
		$message[] = 'Nom d\'utilisateur ou mot de passe incorrect';
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
	<title>Page de connexion admin - Road Luxury</title>
</head>

<body style="padding-left: 0 !important;">
	<?php
	if (isset($message)) {
		foreach ($message as $message) {
			echo '
                <div class="message">
                    <span>' . $message . '</span>
                    <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
                </div>
            ';
		}
	}
	?>
	<div class="main-container">
		<section class="form-container" id="admin_login">
			<form action="" method="post">
				<h3>Se connecter</h3>
				<p style="text-align: center; color: #000;">Nom d'utilisateur par défaut : admin et mot de passe : 1234
				</p>
				<div class="input-field">
					<label>Nom d'utilisateur <sup>*</sup></label><br>
					<input type="text" name="name" maxlength="20" required placeholder="Entrez votre nom d'utilisateur"
						oninput="this.value.replace(/\s/g,'')">
				</div>
				<div class="input-field">
					<label>Mot de passe <sup>*</sup></label><br>
					<input type="password" name="password" maxlength="20" required
						placeholder="Entrez votre mot de passe" oninput="this.value.replace(/\s/g,'')">
				</div>
				<input type="submit" name="submit" value="Se connecter" class="btn">
			</form>
		</section>
	</div>
</body>

</html>