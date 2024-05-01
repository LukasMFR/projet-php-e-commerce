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
// Adding products to wishlist
if (isset($_POST['add_to_wishlist'])) {
	$id = unique_id();
	$product_id = $_POST['product_id']; // This is obtained from the form submission.

	// Verify if product is already in wishlist
	$verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND item_id = ? AND item_type = 'product'");
	$verify_wishlist->execute([$user_id, $product_id]);

	// Corrected: Verify if product is already in cart
	$cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND item_id = ? AND item_type = 'product'");
	$cart_num->execute([$user_id, $product_id]);

	if ($verify_wishlist->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre liste de souhaits';
	} else if ($cart_num->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre panier';
	} else {
		// Select the price of the product
		$select_price = $conn->prepare("SELECT price FROM `products` WHERE id = ? LIMIT 1");
		$select_price->execute([$product_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		// Insert into wishlist
		$insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id, item_id, item_type, price) VALUES(?, ?, ?, 'product', ?)");
		$insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
		$success_msg[] = 'Produit ajouté à la liste de souhaits avec succès';
	}
}
// Adding products to cart
if (isset($_POST['add_to_cart'])) {
	$id = unique_id();
	$product_id = $_POST['product_id'];

	$qty = $_POST['qty'];
	$qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);  // Correctly sanitize as an integer

	// Verify the cart for existing product
	$verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND item_id = ? AND item_type = 'product'");
	$verify_cart->execute([$user_id, $product_id]);

	// Count the number of items in the cart
	$max_cart_items = $conn->prepare("SELECT COUNT(*) FROM `cart` WHERE user_id = ?");
	$max_cart_items->execute([$user_id]);
	$cart_count = $max_cart_items->fetchColumn();

	if ($verify_cart->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre panier';
	} else if ($cart_count >= 20) {
		$warning_msg[] = 'Le panier est plein';
	} else {
		// Select the price of the product
		$select_price = $conn->prepare("SELECT price FROM `products` WHERE id = ? LIMIT 1");
		$select_price->execute([$product_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		// Insert into cart
		$insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id, item_id, item_type, price, qty) VALUES(?,?,?,?,?,?)");
		$insert_cart->execute([$id, $user_id, $product_id, 'product', $fetch_price['price'], $qty]);
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
									<?php echo nl2br($fetch_products['product_detail']); ?>
								</div>
								<section id="skills" class="skills">
									<div class="grid">
										<div class="grid__item skill-item">
											<h1>Caractéristiques du véhicule</h1>
											<ul class="list-unstyled skill-list">
												<li class="skill-list-item">
													<h1>Modèle :</h1>
													<p class="skill-description"><?php echo $fetch_products['Modèle']; ?>
													</p>
												</li>
												<li class="skill-list-item">
													<h1>Année :</h1>
													<p class="skill-description"><?php echo $fetch_products['Année']; ?></p>
												</li>
												<li class="skill-list-item">
													<h1>Moteur :</h1>
													<p class="skill-description"><?php echo $fetch_products['moteur']; ?>
													</p>
												</li>
												<li class="skill-list-item">
													<h1>Kilométrage :</h1>
													<p class="skill-description"><?php echo $fetch_products['kilométrage']; ?>
													</p>
												</li>
												<li class="skill-list-item">
													<h1>Equipements :</h1>
													<p class="skill-description"><?php echo $fetch_products['equipements']; ?>
													</p>
												</li>
												<li class="skill-list-item">
													<h1>Etat :</h1>
													<p class="skill-description"><?php echo $fetch_products['etat']; ?></p>
												</li>
												<li class="skill-list-item">
													<h1>Vitesse de pointe :</h1>
													<p class="skill-description"><?php echo $fetch_products['pointsforts']; ?></p>
													</p>
												</li>
											</ul>
										</div>
									</div>
								</section>

								<input type="hidden" name="product_id"
									value="<?php echo $fetch_products['id']; ?>">
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