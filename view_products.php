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
// Adding products in wishlist
if (isset($_POST['add_to_wishlist'])) {
	$id = unique_id();
	$product_id = $_POST['product_id'];

	$verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND item_id = ? AND item_type = 'product'");
	$verify_wishlist->execute([$user_id, $product_id]);

	// Correct the query to match the `cart` table structure
	$cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND item_id = ? AND item_type = 'product'");
	$cart_num->execute([$user_id, $product_id]);

	if ($verify_wishlist->rowCount() > 0) {
		$warning_msg[] = 'Le produit est déjà dans votre liste de souhaits';
	} else if ($cart_num->rowCount() > 0) {
		$warning_msg[] = 'Le produit est déjà dans votre panier';
	} else {
		// Select the price of the product
		$select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
		$select_price->execute([$product_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		// Insert into wishlist
		$insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id, item_id, item_type, price) VALUES(?, ?, ?, 'product', ?)");
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
	<title>Voitures - Road Luxury</title>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner voiture">
			<h1></h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Voitures</span>
		</div>

		<section class="products">
			<!-- <h1 class="title">Produits dans ma liste de souhaits</h1> -->
			<div class="search-box">
				<i class='bx bx-search-alt-2'></i>
				<input type="text" id="searchInput" placeholder="Chercher une voiture..." autocomplete="off">
			</div>
			<div class="box-container">
				<?php
				$select_products = $conn->prepare("SELECT * FROM `products` WHERE `status` = 'actif'");
				$select_products->execute();
				if ($select_products->rowCount() > 0) {
					while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
						?>
						<form action="" method="post" class="box product-view-form">
							<div class="image-container">
								<img src="image/<?= $fetch_products['image']; ?>" class="img">
								<a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="view-btn">Visualiser</a>
								<div class="button special-button">
									<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
								</div>
							</div>
							<input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
							<h1><?= $fetch_products['name']; ?></h1>
						</form>
						<?php
					}
				} else {
					echo '<p class="empty">Aucun produit actif ajouté pour le moment !</p>';
				}
				?>
			</div>

			<div class="title-product">
				<img src="img/logotime.webp" class="logo-small">
				<h1>Bientôt disponible</h1>
			</div>
			<div class="box-container">
				<?php
				$select_products = $conn->prepare("SELECT * FROM `products` WHERE `status` = 'inactif'");
				$select_products->execute();
				if ($select_products->rowCount() > 0) {
					while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
						?>
						<form action="" method="post" class="box product-view-form">
							<div class="image-container">
								<img src="image/<?= $fetch_products['image']; ?>" class="img">
								<a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="view-btn">Visualiser</a>
								<div class="button special-button">
									<button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
								</div>
							</div>
							<input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
							<h1><?= $fetch_products['name']; ?></h1>
						</form>
						<?php
					}
				} else {
					echo '<p class="empty">Aucun produit inactif pour le moment !</p>';
				}
				?>
			</div>
		</section>

		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const searchInput = document.getElementById('searchInput');
			const forms = document.querySelectorAll('.product-view-form');

			searchInput.addEventListener('keyup', function () {
				const searchValue = searchInput.value.toLowerCase();
				forms.forEach(form => {
					const name = form.querySelector('h1').textContent.toLowerCase();
					if (name.includes(searchValue)) {
						form.style.display = '';
					} else {
						form.style.display = 'none';
					}
				});
			});
		});
	</script>
</body>

</html>