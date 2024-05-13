<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
	exit();
}

if (isset($_POST['delete'])) {
	// Suppression de l'image de profil, si nécessaire
	$select_admin = $conn->prepare("SELECT profile FROM `admin` WHERE id = ?");
	$select_admin->execute([$admin_id]);
	$admin_data = $select_admin->fetch(PDO::FETCH_ASSOC);
	if ($admin_data && file_exists('../image/' . $admin_data['profile'])) {
		unlink('../image/' . $admin_data['profile']);
	}

	// Suppression de l'entrée de l'administrateur dans la base de données
	$delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
	$delete_admin->execute([$admin_id]);

	header('location:../components/admin_logout.php');
	exit();
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
	<title>Comptes administrateurs - Road Luxury</title>
	<?php include '../components/pwa-setup.php'; ?>
</head>

<body>

	<?php include '../components/admin_header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Comptes administrateurs</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Accueil </a><span>/ Comptes administrateurs</span>
		</div>
		<section class="accounts">
			<h1 class="heading">Comptes administrateurs</h1>
			<div class="box-container">
				<?php
				$select_admin = $conn->prepare("SELECT * FROM `admin`");
				$select_admin->execute();
				if ($select_admin->rowCount() > 0) {
					while ($fetch_accounts = $select_admin->fetch(PDO::FETCH_ASSOC)) {
						?>
						<div class="box">
							<div class="profile">
								<img src="../image/<?= $fetch_accounts['profile']; ?>" class="logo-image" width="100">
							</div>
							<p>ID administrateur : <span><?= $fetch_accounts['id']; ?></span></p>
							<p>Nom de l'administrateur : <span><?= $fetch_accounts['name']; ?></span></p>
							<p>Email de l'administrateur : <span><?= $fetch_accounts['email']; ?></span></p>
							<div class="flex-btn">
								<a href="update_profile.php?id=<?= $fetch_accounts['id']; ?>" class="btn">Mettre à jour le
									profil</a>
								<a href="components/admin_logout.php" onclick="return confirm('Se déconnecter du site ?')"
									class="btn">Se déconnecter</a>
							</div>
						</div>
						<?php
					}
				} else {
					echo '
            <div class="empty">
                <p>Aucun administrateur trouvé !</p>
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