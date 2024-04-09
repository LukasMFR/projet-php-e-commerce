<?php 
	 include '../components/connection.php';
	 session_start();

	 $admin_id = $_SESSION['admin_id'];

	 if (!isset($admin_id)) {
	 	header('location: admin_login.php');
	 }
	 if (isset($_POST['delete'])) {
	 	$delete_image = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ?");
	 	$delete_image->execute([$admin_id]);
	 	while($fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC)){
	 		unlink('../update_image/'.$fetch_delete_image);
	 	}

	 	$delete_posts = $conn->prepare("DELETE FROM `posts` WHERE admin_id = ?");
	 	$delete_posts->execute([$admin_id]);
	 	$delete_likes = $conn->prepare("DELETE FROM `likes` WHERE admin_id = ?");
	 	$delete_likes->execute([$admin_id]);
	 	$delete_comment = $conn->prepare("DELETE FROM `comments` WHERE admin_id = ?");
	 	$delete_comment->execute([$admin_id]);

	 	$delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
	 	$delete_admin->execute([$admin_id]);

	 	header('location:../components/admin_logout.php');

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
	<link rel="icon" type="image/png" href="img/favicon-64.png">
	<title>Comptes utilisateurs - Road Luxury</title>
</head>
<body>
	
		<?php include '../components/admin_header.php'; ?>
		<div class="main">
			<div class="banner">
				<h1>Utilisateurs enregistrés</h1>
			</div>
			<div class="title2">
				<a href="dashboard.php">Accueil </a><span>/ Utilisateurs enregistrés</span>
			</div>
			<section class="accounts">
				<h1 class="heading">Utilisateurs enregistrés</h1>
				<div class="box-container">
					<?php 
	 					$select_users = $conn->prepare("SELECT * FROM `users`");
	 					$select_users->execute();
	 					if ($select_users->rowCount() > 0) {
	 						while($fetch_accounts = $select_users->fetch(PDO::FETCH_ASSOC)){
	 							$user_id = $fetch_accounts['id'];
	 							
	 						
					?>
					<div class="box">
						<p>Identifiant : <span><?= $user_id; ?></span></p>
						<p>Nom : <span><?= $fetch_accounts['name']; ?></span></p>
						<p>Email : <span><?= $fetch_accounts['email']; ?></span></p>
						<p>Type d'utilisateur : <span><?= $fetch_accounts['user_type']; ?></span></p>
					</div>
					<?php 
							}
	 					}else{
	 						echo '
								<div class="empty">
									<p>Aucun utilisateur enregistré !</p>
								</div>
							';
	 					}
					?>
				</div>
			</section>
		</div>
	
	<script type="text/javascript" src="script.js"></script>
</body>
</html>