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
		$warning_msg[] = 'Le produit existe déjà dans votre liste de souhaits';
	} else if ($cart_num->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre panier';
	} else {
		$select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
		$select_price->execute([$product_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		$insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id,product_id,price) VALUES(?,?,?,?)");
		$insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
		$success_msg[] = 'Produit ajouté à la liste de souhaits avec succès';
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
		$warning_msg[] = 'Le produit existe déjà dans votre panier';
	} else if ($max_cart_items->rowCount() > 20) {
		$warning_msg[] = 'Le panier est plein';
	} else {
		$select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
		$select_price->execute([$product_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		$insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id,product_id,price,qty) VALUES(?,?,?,?,?)");
		$insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
		$success_msg[] = 'Produit ajouté au panier avec succès';
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
	<title>Détail du produit - Road Luxury</title>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Détail du produit</h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Détail du produit</span>
		</div>
		<section class="view_page">
			<?php
			if (isset($_GET['pid'])) {
				$pid = $_GET['pid'];
				$select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
				$select_products->execute([$pid]);
				if ($select_products->rowCount() > 0) {
					while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
						?>

						<form method="post">
							<div class="product-images">
								<img src="image/<?php echo $fetch_products['image']; ?>" alt="Image principale">
								<div class="image-container">
									<img src="image/<?php echo $fetch_products['image2']; ?>" alt="Image secondaire">
									<img src="image/<?php echo $fetch_products['image3']; ?>" alt="Image tertiaire"
										class="third-image">
								</div>
							</div>
							<div class="detail">
								<div class="price"><?php echo $fetch_products['price']; ?> €</div>
								<div class="name"><?php echo $fetch_products['name']; ?></div>
								<div class="detail">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
										consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
										cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
										proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
									</p>
								</div>
								<section id="skills" class="skills">
									<div class="grid">
										<div class="grid__item skill-item">
											<h3>Caractéristiques du véhicule</h3>
											<ul class="list-unstyled skill-list">
												<li class="skill-list-item">
													 <p class="skill-description">Modèle: <?php echo $fetch_products['Modèle']; ?></p>
												</li>
												<li class="skill-list-item">
													<p class="skill-description">Année: <?php echo $fetch_products['Année']; ?></p>
												</li>
												<li class="skill-list-item">
													<p class="skill-description">Moteur: <?php echo $fetch_products['Moteur']; ?></p>
												</li>
												<li class="skill-list-item">
													<p class="skill-description">Kilométrage: <?php echo $fetch_products['Kilométrage']; ?></p>
												</li>
												<li class="skill-list-item">
													<p class="skill-description">Equipements: <?php echo $fetch_products['Equipements']; ?></p>
												</li>
												<li class="skill-list-item">
													<p class="skill-description">Etat: <?php echo $fetch_products['Etat']; ?></p>
												</li>
												<li class="skill-list-item">
													<p class="skill-description">Points forts: <?php echo $fetch_products['Pointsforts']; ?></p>
												</li>
											</ul>
										</div>
									</div>
								</section>

								<input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
								<div class="button">
									<button type="submit" name="add_to_wishlist" class="btn">Ajouter à la liste de souhaits <i
											class="bx bx-heart"></i></button>
									<input type="hidden" name="qty" value="1" min="0" class="quantity">
									<button type="submit" name="add_to_cart" class="btn">Ajouter au panier <i
											class="bx bx-cart"></i></button>
								</div>
							</div>
						</form>

						<?php
					}
				}
			}
			?>
		</section>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>

</body>

</html>