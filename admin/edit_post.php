<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}

if (isset($_POST['save'])) {
	$post_id = $_GET['id'];
	$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
	$price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
	$content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
	$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
	$annee = filter_var($_POST['Année'], FILTER_VALIDATE_INT);
	$moteur = filter_var($_POST['moteur'], FILTER_SANITIZE_STRING);
	$kilométrage = filter_var($_POST['kilométrage'], FILTER_VALIDATE_INT);
	$equipements = filter_var($_POST['equipements'], FILTER_SANITIZE_STRING);
	$etat = filter_var($_POST['etat'], FILTER_SANITIZE_STRING);
	$pointsforts = filter_var($_POST['pointsforts'], FILTER_SANITIZE_STRING);

	$update_post = $conn->prepare("UPDATE `products` SET name = ?, price = ?, product_detail = ?, status = ?, Année = ?, moteur = ?, kilométrage = ?, equipements = ?, etat = ?, pointsforts = ? WHERE id = ?");
	$update_post->execute([$title, $price, $content, $status, $annee, $moteur, $kilométrage, $equipements, $etat, $pointsforts, $post_id]);

	$success_msg[] = 'Produit mis à jour';

	$image_folder = '../image/'; // Chemin de base pour les images

	handle_image_update('image', $conn, $post_id, $image_folder);
	handle_image_update('image2', $conn, $post_id, $image_folder);
	handle_image_update('image3', $conn, $post_id, $image_folder);
}

// Function to handle image upload and update
function handle_image_update($field_name, $conn, $post_id, $image_folder)
{
	$old_image = $_POST['old_' . $field_name];
	$image = $_FILES[$field_name]['name'];
	$image_size = $_FILES[$field_name]['size'];
	$image_tmp_name = $_FILES[$field_name]['tmp_name'];
	$target_path = $image_folder . $image; // Chemin cible complet

	if (!empty($image)) {
		if ($image_size > 2000000) {
			$warning_msg[] = 'La taille de l\'image ' . $field_name . ' est trop grande';
		} else {
			$select_image = $conn->prepare("SELECT * FROM `products` WHERE $field_name = ?");
			$select_image->execute([$image]);
			if ($select_image->rowCount() > 0 && $image != $old_image) {
				$warning_msg[] = 'Veuillez renommer votre image ' . $field_name;
			} else {
				$update_image = $conn->prepare("UPDATE `products` SET $field_name = ? WHERE id = ?");
				$update_image->execute([$image, $post_id]);
				if (move_uploaded_file($image_tmp_name, $target_path)) {
					if ($old_image != $image && $old_image != '') {
						unlink($image_folder . $old_image);
					}
					$success_msg[] = 'Image ' . $field_name . ' mise à jour !';
				} else {
					$error_msg[] = 'Erreur lors du déplacement du fichier.';
				}
			}
		}
	}
}

// Handling delete post
if (isset($_POST['delete_post'])) {
	$post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_STRING);
	$delete_post = $conn->prepare("DELETE FROM `products` WHERE id = ?");
	$delete_post->execute([$post_id]);
	$success_msg[] = 'Produit supprimé avec succès !';
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
			$select_posts = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
			$select_posts->execute([$post_id]);
			if ($select_posts->rowCount() > 0) {
				$fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC);
				?>
				<div class="form-container">
					<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="old_image" value="<?= $fetch_posts['image']; ?>">
						<input type="hidden" name="old_image2" value="<?= $fetch_posts['image2']; ?>">
						<input type="hidden" name="old_image3" value="<?= $fetch_posts['image3']; ?>">
						<input type="hidden" name="post_id" value="<?= $fetch_posts['id']; ?>">

						<div class="input-field">
							<label>Statut du produit <sup>*</sup></label>
							<select name="status" required>
								<option value="<?= $fetch_posts['status']; ?>" selected><?= $fetch_posts['status']; ?>
								</option>
								<option value="actif">Actif</option>
								<option value="inactif">Inactif</option>
								<option value="Occasion">Occasion</option>
							</select>
						</div>

						<div class="input-field">
							<label>Nom du produit <sup>*</sup></label>
							<input type="text" name="title" required value="<?= $fetch_posts['name']; ?>">
						</div>

						<div class="input-field">
							<label>Prix du produit <sup>*</sup></label>
							<input type="number" name="price" value="<?= $fetch_posts['price']; ?>" step="0.01">
						</div>

						<div class="input-field">
							<label>Détail du produit <sup>*</sup></label>
							<textarea name="content" required><?= $fetch_posts['product_detail']; ?></textarea>
						</div>

						<div class="input-field">
							<label>Année de fabrication <sup>*</sup></label>
							<input type="number" name="Année" required value="<?= $fetch_posts['Année']; ?>">
						</div>

						<div class="input-field">
							<label>Type de moteur <sup>*</sup></label>
							<input type="text" name="moteur" required value="<?= $fetch_posts['moteur']; ?>">
						</div>

						<div class="input-field">
							<label>Nombre de kilomètres <sup>*</sup></label>
							<input type="number" name="kilométrage" required value="<?= $fetch_posts['kilométrage']; ?>">
						</div>

						<div class="input-field">
							<label>Equipements/Options <sup>*</sup></label>
							<textarea name="equipements" required><?= $fetch_posts['equipements']; ?></textarea>
						</div>

						<div class="input-field">
							<label>Etat du produit <sup>*</sup></label>
							<select name="etat" required>
								<option value="<?= $fetch_posts['etat']; ?>" selected><?= $fetch_posts['etat']; ?></option>
								<option value="Neuve">Neuve</option>
								<option value="Occasion">Occasion</option>
							</select>
						</div>

						<div class="input-field">
							<label>Points forts <sup>*</sup></label>
							<textarea name="pointsforts" required><?= $fetch_posts['pointsforts']; ?></textarea>
						</div>

						<?php
						$image_fields = ['image', 'image2', 'image3']; // Liste des champs d'image
						foreach ($image_fields as $index => $field_name) { ?>
							<div class="input-field">
								<label>Image <?= $index + 1; ?> du produit <sup>*</sup></label>
								<input type="file" name="<?= $field_name; ?>"
									accept="image/jpg, image/jpeg, image/png, image/webp">
								<?php if (!empty($fetch_posts[$field_name])) { ?>
									<img src="../image/<?= $fetch_posts[$field_name]; ?>" class="image">
								<?php } ?>
							</div>
						<?php } ?>
						<div class="flex-btn">
							<input type="submit" value="Enregistrer le produit" name="save" class="btn">
							<input type="submit" value="Supprimer le produit" class="option-btn" name="delete_post">
						</div>
					</form>
				</div>
				<?php
			} else {
				echo '<div class="empty"><p>Aucun produit trouvé !</p></div>';
				?>
				<div class="flex-btn">
					<a href="view_posts.php" class="option-btn">Voir les produits</a>
					<a href="add_posts.php" class="btn">Ajouter un produit</a>
				</div>
				<?php
			}
			?>
		</section>
	</div>

	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="script.js"></script>

	<?php include '../components/alert.php'; ?>
</body>

</html>