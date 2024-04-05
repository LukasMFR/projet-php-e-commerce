<?php 
	include 'components/connection.php';
	session_start();

	if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	}else{
		$user_id = '';
	}

	//register user
	if (isset($_POST['submit'])) {
		$id = unique_id();
		$name = $_POST['name'];
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$email = $_POST['email'];
		$email = filter_var($email, FILTER_SANITIZE_STRING);
		$pass = $_POST['pass'];
		$pass = filter_var($pass, FILTER_SANITIZE_STRING);
		$cpass = $_POST['cpass'];
		$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

		$select_user = $conn->prepare("SELECT * FROM `users` WHERE  email = ?");
		$select_user->execute([$email]);
		$row = $select_user->fetch(PDO::FETCH_ASSOC);

		if ($select_user->rowCount() > 0) {
			$warning_msg[] = 'Email déjà existant';
		}else{
			if($pass != $cpass){
				$warning_msg[] = 'Confirmez votre mot de passe';
				
			}else{
				$insert_user = $conn->prepare("INSERT INTO `users`(id,name,email,password) VALUES(?,?,?,?)");
				$insert_user->execute([$id,$name,$email,$pass]);
				header('location: home.php');
				$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
				$select_user->execute([$email, $pass]);
				$row = $select_user->fetch(PDO::FETCH_ASSOC);
				if ($select_user->rowCount() > 0) {
					$_SESSION['user_id'] = $row['id'];
					$_SESSION['user_name'] = $row['name'];
					$_SESSION['user_email'] = $row['email'];
				}
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
	<title>S'enregistrer - Road Luxury</title>
</head>
<body>
	<div class="main-container">
		<section class="form-container">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Inscrivez-vous</h1>
				<p>Rejoignez notre communauté dès aujourd'hui et bénéficiez d'avantages exclusifs. Commencez votre expérience unique avec nous.</p>
			</div>
			<form action="" method="post">
				<div class="input-field">
					<p>Votre nom <sup>*</sup></p>
					<input type="text" name="name" required placeholder="Entrez votre nom" maxlength="50">
				</div>
				<div class="input-field">
					<p>Votre email <sup>*</sup></p>
					<input type="email" name="email" required placeholder="Entrez votre email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				<div class="input-field">
					<p>Votre mot de passe <sup>*</sup></p>
					<input type="password" name="pass" required placeholder="Entrez votre mot de passe" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				<div class="input-field">
					<p>Confirmez le mot de passe <sup>*</sup></p>
					<input type="password" name="cpass" required placeholder="Entrez votre mot de passe" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				<input type="submit" name="submit" value="S'enregistrer" class="btn">
				<p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous maintenant</a></p>
			</form>
		</section>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>