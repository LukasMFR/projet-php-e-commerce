<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}

if (isset($_POST['publish']) || isset($_POST['draft'])) {
	$id = unique_id();
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
	$model = filter_var($_POST['Modèle'], FILTER_SANITIZE_STRING);
	$year = filter_var($_POST['Année'], FILTER_SANITIZE_NUMBER_INT);
	$engine = filter_var($_POST['moteur'], FILTER_SANITIZE_STRING);
	$mileage = filter_var($_POST['kilométrage'], FILTER_SANITIZE_NUMBER_INT);
	$condition = filter_var($_POST['etat'], FILTER_SANITIZE_STRING);
	$detail = filter_var($_POST['product_detail'], FILTER_SANITIZE_STRING);
	$equipment = filter_var($_POST['equipements'], FILTER_SANITIZE_STRING);
	$highlights = filter_var($_POST['pointsforts'], FILTER_SANITIZE_STRING);
	$status = isset($_POST['publish']) ? 'actif' : 'inactif';

	$image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
	$image2 = filter_var($_FILES['image2']['name'], FILTER_SANITIZE_STRING);
	$image3 = filter_var($_FILES['image3']['name'], FILTER_SANITIZE_STRING);
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image2_tmp_name = $_FILES['image2']['tmp_name'];
	$image3_tmp_name = $_FILES['image3']['tmp_name'];
	$image_folder = '../image/' . $image;
	$image2_folder = '../image/' . $image2;
	$image3_folder = '../image/' . $image3;

	move_uploaded_file($image_tmp_name, $image_folder);
	move_uploaded_file($image2_tmp_name, $image2_folder);
	move_uploaded_file($image3_tmp_name, $image3_folder);

	$insert_query = "INSERT INTO `products`(id, name, price, image, image2, image3, product_detail, status, Modèle, Année, moteur, kilométrage, equipements, etat, pointsforts) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$insert_stmt = $conn->prepare($insert_query);
	$insert_stmt->execute([$id, $name, $price, $image, $image2, $image3, $detail, $status, $model, $year, $engine, $mileage, $equipment, $condition, $highlights]);

	$message[] = 'Produit publié';
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
			<h1>Ajouter un produit</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Tableau de bord </a><span>/ Ajouter un produit </span>
		</div>

		<h1 class="heading">Ajouter un produit</h1>
		<div class="form-container">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="input-field">
					<label>Nom du produit <sup>*</sup></label>
					<input type="text" name="name" maxlength="255" required placeholder="Ajoutez le nom du produit">
				</div>
				<div class="input-field">
					<label>Prix du produit <sup>*</sup></label>
					<input type="number" name="price" required placeholder="Ajoutez le prix du produit">
				</div>
				<div class="input-field">
					<label>Modèle <sup>*</sup></label>
					<input type="text" name="Modèle" maxlength="255" required placeholder="Modèle du véhicule">
				</div>
				<div class="input-field">
					<label>Année <sup>*</sup></label>
					<input type="number" name="Année" required placeholder="Année de fabrication">
				</div>
				<div class="input-field">
					<label>Moteur <sup>*</sup></label>
					<input type="text" name="moteur" maxlength="255" required placeholder="Type de moteur">
				</div>
				<div class="input-field">
					<label>Kilométrage <sup>*</sup></label>
					<input type="number" name="kilométrage" required placeholder="Kilométrage du véhicule">
				</div>
				<div class="input-field">
					<label>État <sup>*</sup></label>
					<input type="text" name="etat" maxlength="255" required placeholder="État du véhicule">
				</div>
				<div class="input-field">
					<label>Détail du produit <sup>*</sup></label>
					<textarea name="product_detail" required maxlength="10000"
						placeholder="Détails supplémentaires du produit"></textarea>
				</div>
				<div class="input-field">
					<label>Équipements <sup>*</sup></label>
					<textarea name="equipements" required placeholder="Liste des équipements"></textarea>
				</div>
				<div class="input-field">
					<label>Points forts <sup>*</sup></label>
					<textarea name="pointsforts" required placeholder="Points forts du produit"></textarea>
				</div>
				<div class="input-field">
					<label>Image principale du produit <sup>*</sup></label>
					<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
				</div>
				<div class="input-field">
					<label>Image secondaire 1 <sup>*</sup></label>
					<input type="file" name="image2" accept="image/jpg, image/jpeg, image/png, image/webp" required>
				</div>
				<div class="input-field">
					<label>Image secondaire 2 <sup>*</sup></label>
					<input type="file" name="image3" accept="image/jpg, image/jpeg, image/png, image/webp" required>
				</div>
				<div class="flex-btn">
					<input type="submit" name="publish" value="Publier le produit" class="btn">
					<input type="submit" name="draft" value="Enregistrer en brouillon" class="option-btn">
				</div>
			</form>
		</div>
		</section>
	</div>

	<script type="text/javascript" src="script.js"></script>
</body>

</html>