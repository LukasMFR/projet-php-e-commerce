<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}

if (isset($_POST['save'])) {
	$post_id = $_GET['id']; // Récupération de l'ID depuis l'URL
	$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
	$price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // Validation comme nombre décimal
	$content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
	$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
	$goût = filter_var($_POST['goût'], FILTER_SANITIZE_STRING);
	$taffe = filter_var($_POST['taffe'], FILTER_SANITIZE_NUMBER_INT); // Validation comme entier
	$nicotine = filter_var($_POST['nicotine'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // Validation comme décimal

	$update_post = $conn->prepare("UPDATE `puff` SET name = ?, price = ?, product_detail = ?, status = ?, goût = ?, taffe = ?, nicotine = ? WHERE id = ?");
	$update_post->execute([$title, $price, $content, $status, $goût, $taffe, $nicotine, $post_id]);

	$success_msg[] = 'Produit mis à jour';

	$old_image = $_POST['old_image'];
	$image = $_FILES['image']['name'];
	$image_size = $_FILES['image']['size'];
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image_folder = '../image/' . $image;

	$select_image = $conn->prepare("SELECT * FROM `puff` WHERE image = ?");
	$select_image->execute([$image]);

	if (!empty($image)) {
		if ($image_size > 2000000) {
			$warning_msg[] = 'La taille de l\'image est trop grande';
		} elseif ($select_image->rowCount() > 0 && $image != '') {
			$warning_msg[] = 'Veuillez renommer votre image';
		} else {
			$update_image = $conn->prepare("UPDATE `puff` SET image = ? WHERE id = ?");
			$update_image->execute([$image, $post_id]);
			move_uploaded_file($image_tmp_name, $image_folder);
			if ($old_image != $image && $old_image != '') {
				unlink('../image/' . $old_image);
			}
			$success_msg[] = 'Image mise à jour !';
		}
	}
}

// Code pour supprimer un produit
if (isset($_POST['delete_post'])) {
	$post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_STRING);
	$delete_image = $conn->prepare("SELECT * FROM `puff` WHERE id = ?");
	$delete_image->execute([$post_id]);
	$fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
	if ($fetch_delete_image['image'] != '') {
		unlink('../image/' . $fetch_delete_image['image']);
	}
	$delete_post = $conn->prepare("DELETE FROM `puff` WHERE id = ?");
	$delete_post->execute([$post_id]);
	$success_msg[] = 'Produit supprimé avec succès !';
}

// Code pour supprimer uniquement l'image d'un produit
if (isset($_POST['delete_image'])) {
	$empty_image = '';
	$post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_STRING);
	$delete_image = $conn->prepare("SELECT * FROM `puff` WHERE id = ?");
	$delete_image->execute([$post_id]);
	$fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
	if ($fetch_delete_image['image'] != '') {
		unlink('../image/' . $fetch_delete_image['image']);
	}
	$unset_image = $conn->prepare("UPDATE `puff` SET image = ? WHERE id=?");
	$unset_image->execute([$empty_image, $post_id]);
	$success_msg[] = 'Image supprimée avec succès';
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
	<title>Modifier le produit - Road Luxury</title>
</head>

<body>

	<?php include '../components/admin_header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Modifier le produit</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Accueil </a><span>/ Modifier le produit</span>
		</div>
		<section class="post-editor">
			<h1 class="heading">Modifier le produit</h1>
			<?php
			$post_id = $_GET['id'];
			$select_posts = $conn->prepare("SELECT * FROM `puff` WHERE id =?");
			$select_posts->execute([$post_id]);
			if ($select_posts->rowCount() > 0) {
				while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
					?>
					<div class="form-container edit-post">
						<form action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="old_image" value="<?= $fetch_posts['image']; ?>">
							<input type="hidden" name="post_id" value="<?= $fetch_posts['id']; ?>">
							<div class="input-field">
								<label>Statut du produit <sup>*</sup></label>
								<select name="status" required>
									<option value="<?= $fetch_posts['status']; ?>" selected>
										<?= $fetch_posts['status']; ?>
									</option>
									<option value="actif">actif</option>
									<option value="inactif">inactif</option>
								</select>
							</div>
							<div class="input-field">
								<label>Nom du produit<sup>*</sup></label>
								<input type="text" name="title" maxlength="100" required placeholder="Entrez le nom du produit"
									value="<?= $fetch_posts['name']; ?>">
							</div>
							<div class="input-field">
								<label>Prix du produit <sup>*</sup></label>
								<input type="number" name="price" min="0" step="0.01"
									value="<?= $fetch_posts['price']; ?>" required>
							</div>
							<div class="input-field">
								<label>Détail du produit <sup>*</sup></label>
								<textarea name="content" required maxlength="10000"
									placeholder="Écrivez le détail du produit..."><?= $fetch_posts['product_detail']; ?></textarea>
							</div>
							<div class="input-field">
								<label>Saveur du produit<sup>*</sup></label>
								<input type="text" name="goût" maxlength="100" required
									placeholder="Entrez la saveur du produit"
									value="<?= $fetch_posts['goût']; ?>">
							</div>
							<div class="input-field">
								<label>Taux de nicotine <sup>*</sup></label>
								<input type="number" name="nicotine" min="0" step="0.01"
									value="<?= $fetch_posts['nicotine']; ?>" required>
							</div>
							<div class="input-field">
								<label>Nombre de taffes du produit<sup>*</sup></label>
								<input type="number" name="taffe" min="0"
									value="<?= $fetch_posts['taffe']; ?>" required>
							</div>
							<div class="input-field">
								<label>Image du produit <sup>*</sup></label>
								<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">
								<?php if ($fetch_posts['image'] != '') { ?>
									<img src="../image/<?= $fetch_posts['image']; ?>" class="image">
									<div class="flex-btn">
										<input type="submit" name="delete_image" class="option-btn" value="Supprimer l'image">
										<a href="view_posts_puff.php" class="btn">Retour</a>
									</div>
								<?php } ?>
							</div>
							<div class="flex-btn">
								<input type="submit" value="Enregistrer le produit" name="save" class="btn">
								<input type="submit" value="Supprimer le produit" class="option-btn" name="delete_post">
							</div>
						</form>
					</div>
					<?php
				}
			} else {
				echo '
            <div class="empty">
                <p>Aucun produit trouvé !</p>
            </div>
        ';
				?>
				<div class="flex-btn">
					<a href="view_posts.php" class="option-btn">Voir le produit</a>
					<a href="add_posts.php" class="btn">Ajouter un produit</a>
				</div>
			<?php } ?>
		</section>
	</div>

	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="script.js"></script>

	<?php include '../components/alert.php'; ?>
</body>

</html>