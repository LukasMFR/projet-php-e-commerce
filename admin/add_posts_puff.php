<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}

if (isset($_POST['publish']) || isset($_POST['draft'])) {
	$id = unique_id();
	$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
	$price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
	$goût = filter_var($_POST['goût'], FILTER_SANITIZE_STRING); // Correctly handling 'goût'
	$taffe = filter_var($_POST['taffe'], FILTER_VALIDATE_INT);
	$nicotine = filter_var($_POST['nicotine'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$status = isset($_POST['publish']) ? 'actif' : 'inactif';

	$image = $_FILES['image']['name'];
	$image = filter_var($image, FILTER_SANITIZE_STRING);
	$image_size = $_FILES['image']['size'];
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image_folder = '../image/' . basename($image);

	if ($image_size > 2000000) {
		$error_msg[] = 'Taille de l\'image trop grande !';
	} elseif (!move_uploaded_file($image_tmp_name, $image_folder)) {
		$error_msg[] = 'Erreur lors du téléchargement de l\'image.';
	} else {
		$select_image = $conn->prepare("SELECT * FROM `puff` WHERE image = ?");
		$select_image->execute([$image]);
		if ($select_image->rowCount() > 0) {
			$error_msg[] = 'Nom de l\'image déjà utilisé !';
		} else {
			$insert_post = $conn->prepare("INSERT INTO `puff`(id, name, price, image, product_detail, status, goût, taffe, nicotine) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$insert_post->execute([$id, $title, $price, $image, $content, $status, $goût, $taffe, $nicotine]);
			$success_msg[] = 'Produit ' . (isset($_POST['publish']) ? 'publié' : 'enregistré en brouillon') . '.';
		}
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
	<title>Ajouter un produit - Road Luxury</title>
</head>

<body>

	<?php include '../components/admin_header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Ajouter une puff</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Tableau de bord </a><span>/ Ajouter une Puff </span>
		</div>

		<!-- <h1 class="heading">Ajouter un produit</h1> -->
		<div class="form-container add-post">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="input-field">
					<label>Nom du produit <sup>*</sup></label>
					<input type="text" name="title" maxlength="100" required placeholder="Ajoutez le nom du produit">
				</div>
				<div class="input-field">
					<label>Prix du produit <sup>*</sup></label>
					<input type="text" name="price" maxlength="100" required placeholder="Ajoutez le prix du produit">
				</div>
				<div class="input-field">
					<label>Détail du produit<sup>*</sup></label>
					<textarea name="content" required maxlength="10000"
						placeholder="Ajoutez le détail du produit"></textarea>
				</div>
				<div class="input-field">
					<label>Goût du produit <sup>*</sup></label>
					<input type="text" name="goût" required placeholder="Ajoutez le goût du produit">
				</div>
				<div class="input-field">
					<label>Taffe <sup>*</sup></label>
					<input type="number" name="taffe" required placeholder="Ajoutez le nombre de taffes">
				</div>
				<div class="input-field">
					<label>Nicotine (%) <sup>*</sup></label>
					<input type="text" name="nicotine" pattern="^\d*(\.\d{0,2})?$"
						title="Please enter a valid percentage (e.g., 5, 5.5)" required
						placeholder="Ajoutez la teneur en nicotine en %">
				</div>
				<div class="input-field">
					<label>Image du produit <sup>*</sup></label>
					<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
				</div>
				<div class="flex-btn">
					<input type="submit" name="publish" value="Publier le produit" class="btn">
					<input type="submit" name="draft" value="Enregistrer en brouillon" class="option-btn">
				</div>
			</form>
		</div>
		</section>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
	<?php include '../components/alert.php'; ?>
</body>

</html>