<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}

if (isset($_POST['save'])) {
	$post_id = $_GET['id'];
	$title = $_POST['title'];
	$title = filter_var($title, FILTER_SANITIZE_STRING);
	$price = $_POST['price'];
	$price = filter_var($price, FILTER_SANITIZE_STRING);
	$content = $_POST['content'];
	$content = filter_var($content, FILTER_SANITIZE_STRING);
	$status = $_POST['status'];
	$status = filter_var($status, FILTER_SANITIZE_STRING);
	$annee = $_POST['Année'];
	$annee = filter_var($annee, FILTER_SANITIZE_STRING);
	$moteur = $_POST['moteur'];
	$moteur = filter_var($moteur, FILTER_SANITIZE_STRING);
	$kilométrage = $_POST['kilométrage'];
	$kilométrage = filter_var($kilométrage, FILTER_SANITIZE_STRING);
	$equipements = $_POST['equipements'];
	$equipements = filter_var($equipements, FILTER_SANITIZE_STRING);
	$etat = $_POST['etat'];
	$etat = filter_var($etat, FILTER_SANITIZE_STRING);
	$pointsforts = $_POST['pointsforts'];
	$pointsforts = filter_var($pointsforts, FILTER_SANITIZE_STRING);

	$update_post = $conn->prepare("UPDATE `products` SET name = ?, price = ?, product_detail = ?,status = ?, Année = ?, moteur = ?, kilométrage = ?, equipements = ?, etat = ?, pointsforts = ? WHERE id = ?");
	$update_post->execute([$title, $price, $content, $status, $annee, $moteur, $kilométrage, $equipements, $etat, $pointsforts, $post_id]);

	$success_msg[] = 'Produit mis à jour';

	$old_image = $_POST['old_image'];
	$image = $_FILES['image']['name'];
	$image_size = $_FILES['image']['size'];
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image_folder = '../image/' . $image;


	$select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
	$select_image->execute([$image]);

	if (!empty($image)) {
		if ($image_size > 2000000) {
			$warning_msg[] = 'La taille de l\'image est trop grande';
		} elseif ($select_image->rowCount() > 0 and $image != '') {
			$warning_msg[] = 'Veuillez renommer votre image';
		} else {
			$update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
			$update_image->execute([$image, $post_id]);
			move_uploaded_file($image_tmp_name, $image_folder);
			if ($old_image != $image and $old_image != '') {
				unlink('../image/' . $old_image);
			}
			$success_msg[] = 'Image mise à jour !';
		}
	}

	$old_image2 = $_POST['old_image2'];
	$image2 = $_FILES['image2']['name'];
	$image2_size = $_FILES['image2']['size'];
	$image2_tmp_name = $_FILES['image2']['tmp_name'];
	$image2_folder = '../image/' . $image2;

	$select_image = $conn->prepare("SELECT * FROM `products` WHERE image2 = ?");
	$select_image->execute([$image2]);

	{
	if (!empty($image2)) 
    if ($image2_size > 2000000) {
        $warning_msg[] = 'La taille de l\'image2 est trop grande';
   	 	} else {
        $update_image2 = $conn->prepare("UPDATE `products` SET image2 = ? WHERE id = ?");
        $update_image2->execute([$image2, $post_id]);
        move_uploaded_file($image2_tmp_name, $image2_folder);
        if ($old_image2 != $image2 && $old_image2 != '') {
            unlink('../image/' . $old_image2);
        }
        $success_msg[] = 'Image2 mise à jour !';
    	}
	}

	$old_image3 = $_POST['old_image3'];
	$image3 = $_FILES['image3']['name'];
	$image3_size = $_FILES['image3']['size'];
	$image3_tmp_name = $_FILES['image3']['tmp_name'];
	$image3_folder = '../image/' . $image3;

	$select_image = $conn->prepare("SELECT * FROM `products` WHERE image3= ?");
	$select_image->execute([$image3]);

	{
	if (!empty($image3)) 
    if ($image3_size > 2000000) {
        $warning_msg[] = 'La taille de l\'image3 est trop grande';
   	 	} else {
        $update_image3 = $conn->prepare("UPDATE `products` SET image3 = ? WHERE id = ?");
        $update_image3->execute([$image3, $post_id]);
        move_uploaded_file($image3_tmp_name, $image3_folder);
        if ($old_image3 != $image3 && $old_image3 != '') {
            unlink('../image/' . $old_image3);
        }
        $success_msg[] = 'Image3 mise à jour !';
    	}
	}

	
} 


	





//delete post
if (isset($_POST['delete_post'])) {

	$post_id = $_POST['post_id'];
	$post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
	$delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
	$delete_image->execute([$post_id]);
	$fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
	if ($fetch_delete_image['image'] != '') {
		unlink('../image/' . $fetch_delete_image['image']);
	}
	$delete_post = $conn->prepare("DELETE FROM `products` WHERE id = ?");
	$delete_post->execute([$post_id]);
	$delete_comments = $conn->prepare("DELETE FROM `comments` WHERE post_id = ?");
	$delete_comments->execute([$post_id]);
	$success_msg[] = 'Produit supprimé avec succès !';

}

//delete image 

if (isset($_POST['delete_image'])) {
	$empty_image = '';
	$post_id = $_POST['post_id'];
	$post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
	$delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
	$delete_image->execute([$post_id]);
	$fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
	if ($fetch_delete_image['image'] != '') {
		unlink('../image/' . $fetch_delete_image['image']);
	}
	$unset_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id=?");
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
			$select_posts = $conn->prepare("SELECT * FROM `products` WHERE id =?");
			$select_posts->execute([$post_id]);
			if ($select_posts->rowCount() > 0) {
				while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {


					?>
					<div class="form-container">
						<form action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="old_image" value="<?= $fetch_posts['image']; ?>">
							<input type="hidden" name="post_id" value="<?= $fetch_posts['id']; ?>">
							<div class="input-field">
								<label>Statut du produit <sup>*</sup></label>
								<select name="status" required>
									<option value="<?= $fetch_posts['status']; ?>" selected><?= $fetch_posts['status']; ?>
									</option>
									<option value="actif">Actif</option>
									<option value="inactif">Inactif</option>
									<option value="Occasion">Puff</option>
								</select>
							</div>
							<div class="input-field">
								<label>Nom du produit<sup>*</sup></label>
								<input type="text" name="title" maxlength="100" required placeholder="add post title"
									value="<?= $fetch_posts['name']; ?>">
							</div>

							<div class="input-field">
								<label>Prix du produit <sup>*</sup></label>
								<input type="text" name="price" value="<?= $fetch_posts['price']; ?>">

							</div>

							<div class="input-field">
								<label>Détail du produit <sup>*</sup></label>
								<textarea name="content" required maxlength="10000"
									placeholder="write your content.."><?= $fetch_posts['product_detail']; ?></textarea>
							</div>
							
							<div class="input-field">
								<label>Année de fabrication<sup>*</sup></label>
								<input type="text" name="Année" maxlength="100" required placeholder="add post title"
									value="<?= $fetch_posts['Année']; ?>">
							</div>

							<div class="input-field">
								<label>Type de moteur<sup>*</sup></label>
								<input type="text" name="moteur" maxlength="100" required placeholder="add post title"
									value="<?= $fetch_posts['moteur']; ?>">
							</div>

							<div class="input-field">
								<label>Nombre de kilométre<sup>*</sup></label>
								<input type="text" name="kilométrage" maxlength="100" required placeholder="add post title"
									value="<?= $fetch_posts['kilométrage']; ?>">
							</div>

							<div class="input-field">
								<label>Equipements/Options<sup>*</sup></label>
								<textarea name="equipements" required maxlength="10000"
									placeholder="write your content.."><?= $fetch_posts['equipements']; ?></textarea>
							</div>

							<div class="input-field">
								<label>Statut du produit <sup>*</sup></label>
								<select name="etat" required>
									<option value="<?= $fetch_posts['etat']; ?>" selected><?= $fetch_posts['etat']; ?>
									</option>
									<option value="Neuve">Neuve</option>
									<option value="Occasion">Occasion</option>
								</select>
							</div>

							<div class="input-field">
								<label>Vitesse de pointe<sup>*</sup></label>
								<input type="text" name="pointsforts" maxlength="100" required placeholder="add post title"
									value="<?= $fetch_posts['pointsforts']; ?>">
							</div>

							<div class="input-field">
								<label>Image 1 du produit <sup>*</sup></label>
								<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">
								<?php if ($fetch_posts['image'] != '') { ?>
									<img src="../image/<?= $fetch_posts['image']; ?>" class="image">

							<div class="input-field">
								<label>Image 2 du produit <sup>*</sup></label>
								<input type="file" name="image2" accept="image/jpg, image/jpeg, image/png, image/webp">
								<?php if ($fetch_posts['image2'] != '') { ?>
									<img src="../image/<?= $fetch_posts['image2']; ?>" class="image">

							<div class="input-field">
								<label>Image 3 du produit <sup>*</sup></label>
								<input type="file" name="image3" accept="image/jpg, image/jpeg, image/png, image/webp">
								<?php if ($fetch_posts['image3'] != '') { ?>
									<img src="../image/<?= $fetch_posts['image3']; ?>" class="image">
									<div class="flex-btn">
										<input type="submit" name="delete_image" class="option-btn" value="Supprimer l'image">
										<a href="view_posts.php" class="btn"
											style="width:49%; text-align: center; font-size: 1.2rem; margin: .5rem;">Retour</a>
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
			}
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