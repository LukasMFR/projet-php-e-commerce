<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}

$get_id = $_GET['post_id'];

// Suppression du produit de la base de données
if (isset($_POST['delete'])) {
	$p_id = filter_var($_POST['post_id'], FILTER_SANITIZE_STRING);

	// Sélectionner les informations du produit pour supprimer les images
	$select_images = $conn->prepare("SELECT image, image2, image3 FROM `products` WHERE id = ?");
	$select_images->execute([$p_id]);
	$images = $select_images->fetch(PDO::FETCH_ASSOC);

	// Supprimer les fichiers image du serveur
	foreach (['image', 'image2', 'image3'] as $image_field) {
		if (!empty($images[$image_field])) {
			unlink('../image/' . $images[$image_field]);
		}
	}

	// Supprimer le produit de la base de données
	$delete_post = $conn->prepare("DELETE FROM `products` WHERE id = ?");
	$delete_post->execute([$p_id]);

	// Rediriger l'utilisateur vers la page de vue d'ensemble des produits
	header('Location: view_posts.php');
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
	<title>Voir le produit - Road Luxury</title>
</head>

<body>

	<?php include '../components/admin_header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Voir le produit</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Accueil </a><span>/ Voir le produit</span>
		</div>
		<section class="read-container">
			<?php
			if (isset($message) && is_array($message)) {
				foreach ($message as $msg) {
					echo '
            <div class="message">
                <span>' . $msg . '</span>
                <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
            </div>
            ';
				}
			}
			?>
			<div class="read-post">
				<?php
				$select_posts = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
				$select_posts->execute([$get_id]);
				if ($select_posts->rowCount() > 0) {
					while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
						?>
						<form method="post">
							<input type="hidden" name="post_id" value="<?= $fetch_posts['id']; ?>">
							<div class="status"
								style="background-color: <?= $fetch_posts['status'] == 'actif' ? 'limegreen' : 'coral'; ?>;">
								<?= $fetch_posts['status']; ?>
							</div>
							<div class="image-box">
								<!-- Affichage de toutes les images associées au produit -->
								<?php if ($fetch_posts['image'] != '') { ?>
									<img src="../image/<?= $fetch_posts['image'] ?>" class="image">
								<?php } ?>
								<?php if ($fetch_posts['image2'] != '') { ?>
									<img src="../image/<?= $fetch_posts['image2'] ?>" class="image">
								<?php } ?>
								<?php if ($fetch_posts['image3'] != '') { ?>
									<img src="../image/<?= $fetch_posts['image3'] ?>" class="image">
								<?php } ?>
							</div>
							<div class="title"><?= $fetch_posts['name'] ?></div>
							<div class="content"><?= $fetch_posts['product_detail'] ?></div>
							<div class="flex-btn">
								<a href="edit_post.php?id=<?= $fetch_posts['id']; ?>" class="btn">Modifier</a>
								<button type="submit" name="delete" class="btn"
									onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
								<a href="view_posts.php" class="btn">Retour</a>
							</div>
						</form>
						<?php
					}
				} else {
					echo '
                <div class="empty">
                    <p>Aucun article ajouté pour le moment ! <br><a href="add_posts.php" class="btn" style="margin-top: 1.5rem;">Ajouter un article</a></p>
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