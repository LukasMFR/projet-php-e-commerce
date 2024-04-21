<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
} else {
	$user_id = '';
}

if (isset($_POST['logout'])) {
	session_destroy();
	header("location: login.php");
}
//adding products in wishlist
if (isset($_POST['add_to_wishlist'])) {
	$id = unique_id();
	$product_id = $_POST['product_id'];

	$varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
	$varify_wishlist->execute([$user_id, $product_id]);

	$cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
	$cart_num->execute([$user_id, $product_id]);

	if ($varify_wishlist->rowCount() > 0) {
		$warning_msg[] = 'Le produit est déjà dans votre liste de souhaits';
	} else if ($cart_num->rowCount() > 0) {
		$warning_msg[] = 'Le produit est déjà dans votre panier';
	} else {
		$select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
		$select_price->execute([$product_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		$insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id,product_id,price) VALUES(?,?,?,?)");
		$insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
		$success_msg[] = 'Produit ajouté avec succès à la liste de souhaits';
	}
}
//adding products in cart
if (isset($_POST['add_to_cart'])) {
	$id = unique_id();
	$product_id = $_POST['product_id'];

	$qty = $_POST['qty'];
	$qty = filter_var($qty, FILTER_SANITIZE_STRING);

	$varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
	$varify_cart->execute([$user_id, $product_id]);

	$max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
	$max_cart_items->execute([$user_id]);

	if ($varify_cart->rowCount() > 0) {
		$warning_msg[] = 'Le produit est déjà dans votre panier';
	} else if ($max_cart_items->rowCount() > 20) {
		$warning_msg[] = 'Le panier est plein';
	} else {
		$select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
		$select_price->execute([$product_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		$insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id,product_id,price,qty) VALUES(?,?,?,?,?)");
		$insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
		$success_msg[] = 'Produit ajouté avec succès au panier';
	}
}

?>
<style type="text/css">
	<?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="img/favicon-64.png">
	<title>Boutique - Road Luxury</title>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Boutique</h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Notre boutique</span>
		</div>
		<section class="products">

			<div class="box-container">
				<div class="box">
					<img src="image/mc1.jpg">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=BLTtlhOgq1cuz7plh4Ia" class="btn">Visualiser</a>
					<h1>Maclaren 720s</h1>
				</div>
				<div class="box">
					<img src="image/bugatienoir.jpg">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=jo35YMmBWpvbCMB65UdA" class="btn">Visualiser</a>
					<h1>Bugatti La voiture Noire</h1>
				</div>
				<div class="box">
					<img src="image/lambo4.jpg">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=aSBHDzG26iXurm6cfoNv" class="btn">Visualiser</a>
					<h1>Lamborghini Revuelto</h1>
				</div>
			</div>

			<div class="box-container">
				<div class="box">
					<img src="image/Alpine.jpg">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=g5DLcNHmtHvq3DtJYsCb" class="btn">Visualiser</a>
					<h1>Alpine A110 RS</h1>
				</div>
				<div class="box">
					<img src="image/ferariesp51.png">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=uOarNNg0n3KD9OvPtItP" class="btn">Visualiser</a>
					<h1>Ferrarie SP51</h1>
				</div>
				<div class="box">
					<img src="image/porche.png">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=26lPPTjXh9EkNc7WocS5" class="btn">Visualiser</a>
					<h1>Lamborghini Revuelto</h1>
				</div>
			</div>

			<div class="box-container">
				<div class="box">
					<img src="image/urus1.jpg">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=kun96OpQed6Eww6M1URo" class="btn">Visualiser</a>
					<h1>Lamborhhini Urus</h1>
				</div>
				<div class="box">
					<img src="image/mercedes1.jpg">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=wrJTrzoHsuEwr7hGi3R6" class="btn">Visualiser</a>
					<h1>Mercedes AMG GT2</h1>
				</div>
				<div class="box">
					<img src="image/maserati1.jpg">
					<div class="button special-button">
								<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
							</div>
					<a href="view_page.php?pid=eBbtkVNYiJJKT9mCgYbk" class="btn">Visualiser</a>
					<h1>Lamborghini Revuelto</h1>
				</div>
			</div>			
		</section>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>

</html>