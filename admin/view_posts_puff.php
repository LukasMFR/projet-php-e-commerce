<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}

//delete post from database

if (isset($_POST['delete'])) {
	$p_id = $_POST['puff_id'];
	$p_id = filter_var($p_id, FILTER_SANITIZE_STRING);


	$delete_post = $conn->prepare("DELETE FROM `puff` WHERE id = ?");
	$delete_post->execute([$p_id]);

	$message[] = 'Produit supprimé avec succès !';
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<title>Les produits - Road Luxury</title>
</head>

<body>

	<?php include '../components/admin_header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Tous les produits</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Accueil </a><span>/ Tous les produits</span>
		</div>
		<section class="post-editor">
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

			<h1 class="heading"></h1>
			<div class="show-post">
				<div class="box-container">
					<?php
					$select_posts = $conn->prepare("SELECT * FROM `puff`");
					$select_posts->execute();
					if ($select_posts->rowCount() > 0) {
						while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {


							?>
							<form method="post" class="box">
								<input type="hidden" name="ppuff_id" value="<?= $fetch_posts['id']; ?>">
								<?php if ($fetch_posts['image'] != '') { ?>
									<img src="../image/<?= $fetch_posts['image'] ?>" class="image">
								<?php } ?>
								<div class="status" style="color: <?php if ($fetch_posts['status'] == 'actif') {
									echo 'limegreen';
								} else {
									echo "coral";
								} ?>;">
									<?= $fetch_posts['status'] ?>
								</div>
								<div class="price"><?= $fetch_posts['price'] ?> €</div>
								<div class="title"><?= $fetch_posts['name'] ?></div>
								<div class="flex-btn">
									<a href="edit_post_puff.php?id=<?= $fetch_posts['id']; ?>" class="btn"><i class="fa-solid fa-pen"></i></a>
									<button type="submit" name="delete" class="btn"
										onclick="return confirm('Supprimer cet article ?')"><i class="fa-solid fa-trash"></i></button>
									<a href="read_posts.php?post_id=<?= $fetch_posts['id']; ?>" class="btn"><i class="fa fa-eye"></i></a>
								</div>
							</form>
							<?php
						}
					} else {

						echo '
								<div class="empty">
									<p>Aucun produit pour le moment ! <br><a href="add_posts.php" class="btn" style="margin-top: 1.5rem;">Ajouter un produit</a></p>
								</div>
							';
					}
					?>
				</div>

			</div>
		</section>
	</div>

	<script type="text/javascript" src="script.js"></script>
</body>

</html>