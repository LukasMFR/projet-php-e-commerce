<?php 
	 include '../components/connection.php';
	 session_start();

	 $admin_id = $_SESSION['admin_id'];

	 if (!isset($admin_id)) {
	 	header('location: admin_login.php');
	 }

	 if (isset($_POST['publish'])) {
	 	$id = unique_id();
	   	$title = $_POST['title'];
	   	$title = filter_var($title, FILTER_SANITIZE_STRING);

	   	$price = $_POST['price'];
	   	$price = filter_var($price, FILTER_SANITIZE_STRING);

	   	$content = $_POST['content'];
	   	$content = filter_var($content, FILTER_SANITIZE_STRING);

	   	$status = 'actif';

	   	$image = $_FILES['image']['name'];
	   	$image = filter_var($image, FILTER_SANITIZE_STRING);
	   	$image_size = $_FILES['image']['size'];
	   	$image_tmp_name = $_FILES['image']['tmp_name'];
	   	$image_folder = '../image/'.$image;

	   	$select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
	   	$select_image->execute([$image]);

	   	if (isset($image)) {
	   		if ($select_image->rowCount() > 0) {
	   			$message[] = 'Nom de l\'image déjà utilisé !';
	   		}elseif($image_size > 2000000){
	   			$message[] = 'Taille de l\'image trop grande !';
	   		}else{
	   			move_uploaded_file($image_tmp_name, $image_folder);
	   		}
	   	}else{
	   		$image = '';
	   	}
	   	if ($select_image->rowCount() > 0 AND $image != '') {
	   		$message[] = 'Veuillez renommer votre image';
	   	}else{
	   		$insert_post = $conn->prepare("INSERT INTO `products`(id, name, price, image, product_detail, status) VALUES (?,?,?,?,?,?)");
	   		$insert_post->execute([$id, $title, $price, $image, $content, $status]);
	   		$message[] = 'Produit publié';
	   	}
	 }

	 //post adding in draft
	 if (isset($_POST['draft'])) {
	 	$id = unique_id();
	   	$title = $_POST['title'];
	   	$title = filter_var($title, FILTER_SANITIZE_STRING);

	   	$price = $_POST['price'];
	   	$price = filter_var($price, FILTER_SANITIZE_STRING);

	   	$content = $_POST['content'];
	   	$content = filter_var($content, FILTER_SANITIZE_STRING);

	   	$status = 'inactif';

	   	$image = $_FILES['image']['name'];
	   	$image = filter_var($image, FILTER_SANITIZE_STRING);
	   	$image_size = $_FILES['image']['size'];
	   	$image_tmp_name = $_FILES['image']['tmp_name'];
	   	$image_folder = '../image/'.$image;

	   	$select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND admin_id = ?");
	   	$select_image->execute([$image, $admin_id]);

	   	if (isset($image)) {
	   		if ($select_image->rowCount() > 0) {
	   			$message[] = 'Nom de l\'image déjà utilisé !';
	   		}elseif($image_size > 2000000){
	   			$message[] = 'Taille de l\'image trop grande !';
	   		}else{
	   			move_uploaded_file($image_tmp_name, $image_folder);
	   		}
	   	}else{
	   		$image = '';
	   	}
	   	if ($select_image->rowCount() > 0 AND $image != '') {
	   		$message[] = 'Veuillez renommer votre image';
	   	}else{
	   		$insert_post = $conn->prepare("INSERT INTO `products`(id, name, price, image, product_detail, status) VALUES (?,?,?,?,?,?)");
	   		$insert_post->execute([$id, $title, $price, $image, $content, $status]);
	   		$message[] = 'Produit publié';
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
	<title>Ajouter un produit - AutoCar</title>
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
						<input type="text" name="title" maxlength="100" required placeholder="Ajoutez le nom du produit">
					</div>
					<div class="input-field">
						<label>Prix du produit <sup>*</sup></label>
						<input type="number" name="price" maxlength="100" required placeholder="Ajoutez le prix du produit">
					</div>
					<div class="input-field">
						<label>Détail du produit<sup>*</sup></label>
						<textarea name="content" required maxlength="10000" placeholder="Ajoutez le détail du produit"></textarea>
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
	
	<script type="text/javascript" src="script.js"></script>
</body>
</html>