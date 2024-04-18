<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}

//delete review 
if (isset($_POST['delete_review'])) {
	$delete_id = $_POST['delete_id'];
	$delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

	$verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id = ?");
	$verify_delete->execute([$delete_id]);

	if ($verify_delete->rowCount() > 0) {
		$delete_review = $conn->prepare("DELETE FROM `message` WHERE id = ?");
		$delete_review->execute([$delete_id]);
		$success_msg[] = "Message supprimé";
	} else {
		$warning_msg[] = 'Message déjà supprimé';
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
	<title>Messages - Road Luxury</title>
</head>

<body>

	<?php include '../components/admin_header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Messages des utilisateurs</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Accueil </a><span>/ Messages</span>
		</div>
		<section class="message-container">
			<div class="heading">
				<h1>Messages des utilisateurs</h1>
			</div>
			<div class="box-container">
				<?php
				$select_reviews = $conn->prepare("SELECT * FROM `message`");
				$select_reviews->execute();
				if ($select_reviews->rowCount() > 0) {
					while ($fetch_review = $select_reviews->fetch(PDO::FETCH_ASSOC)) {


						?>
						<div class="box">
							<h3 class="name"><?= $fetch_review['name']; ?></h3>
							<h4><?= $fetch_review['subject']; ?></h4>
							<p><?= $fetch_review['message']; ?></p>

							<form action="" method="post" class="flex-btn">
								<input type="hidden" name="delete_id" value="<?= $fetch_review['id']; ?>">

								<input type="submit" name="delete_review" value="Supprimer le message" class="btn"
									onclick="return confirm('Supprimer ce message ?');">
							</form>

						</div>
						<?php
					}
				} else {
					echo '<p class="empty">Aucun message ajouté pour le moment !</p>';
				}
				?>
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