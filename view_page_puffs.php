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
// Adding puff to wishlist
if (isset($_POST['add_to_wishlist'])) {
	$id = unique_id();
	$puff_id = $_POST['puff_id'];

	// Verify if puff is already in wishlist
	$verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND item_id = ? AND item_type = 'puff'");
	$verify_wishlist->execute([$user_id, $puff_id]);

	// Verify if puff is already in cart (correct field names according to new schema)
	$cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND item_id = ? AND item_type = 'puff'");
	$cart_num->execute([$user_id, $puff_id]);

	if ($verify_wishlist->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre liste de souhaits';
	} else if ($cart_num->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre panier';
	} else {
		// Select the price of the puff
		$select_price = $conn->prepare("SELECT price FROM `puff` WHERE id = ? LIMIT 1");
		$select_price->execute([$puff_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		// Insert into wishlist
		$insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id, item_id, item_type, price) VALUES(?, ?, ?, 'puff', ?)");
		$insert_wishlist->execute([$id, $user_id, $puff_id, $fetch_price['price']]);
		$success_msg[] = 'Produit ajouté à la liste de souhaits avec succès';
	}
}
// Adding puff to cart
if (isset($_POST['add_to_cart'])) {
	$id = unique_id();
	$puff_id = $_POST['puff_id'];  // Correctly handling the puff ID

	$qty = $_POST['qty'];
	$qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT); // Ensuring quantity is a valid integer

	// Verify the cart for existing puff
	$verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND item_id = ? AND item_type = 'puff'");
	$verify_cart->execute([$user_id, $puff_id]);  // Adjusted to include item_type

	// Check the number of items in the cart
	$max_cart_items = $conn->prepare("SELECT COUNT(*) FROM `cart` WHERE user_id = ?");
	$max_cart_items->execute([$user_id]);
	$cart_count = $max_cart_items->fetchColumn();

	if ($verify_cart->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre panier';
	} else if ($cart_count >= 20) {
		$warning_msg[] = 'Le panier est plein';
	} else {
		// Select the price of the puff
		$select_price = $conn->prepare("SELECT price FROM `puff` WHERE id = ? LIMIT 1");
		$select_price->execute([$puff_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		// Insert into cart
		$insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id, item_id, item_type, price, qty) VALUES(?,?,?,?,?,?)");
		$insert_cart->execute([$id, $user_id, $puff_id, 'puff', $fetch_price['price'], $qty]);
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
	<?php include 'components/meta_tags.php'; ?>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner puff_page">
			<h1></h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Détail du produit</span>
		</div>
		<section class="view_page">
			<?php
			if (isset($_GET['pid'])) {
				$pid = $_GET['pid'];
				$select_puff = $conn->prepare("SELECT * FROM `puff` WHERE id = ?");
				$select_puff->execute([$pid]);
				if ($select_puff->rowCount() > 0) {
					while ($fetch_puff = $select_puff->fetch(PDO::FETCH_ASSOC)) {
						?>

						<form method="post">
							<div class="product-container">
								<div class="product-images">
									<img src="image/<?php echo $fetch_puff['image']; ?>" alt="Image principale" class="puff">
								</div>
								<div class="detail">
									<div class="price"><?php echo number_format($fetch_puff['price'], 2, ',', ' '); ?> €</div>
									<div class="name"><?php echo $fetch_puff['name']; ?></div>
									<div class="detail">
										<?php echo nl2br($fetch_puff['product_detail']); ?>
									</div>
									<section id="skills" class="skills">
										<div class="grid">
											<div class="grid__item skill-item">
												<h1>Caractéristiques du véhicule</h1>
												<ul class="list-unstyled skill-list">
													<li class="skill-list-item">
														<h1>Saveur :</h1>
														<p class="skill-description"><?php echo $fetch_puff['goût']; ?>
														</p>
													</li>
													<li class="skill-list-item">
														<h1>Nombre de taffe :</h1>
														<p class="skill-description"><?php echo $fetch_puff['taffe']; ?></p>
													</li>
													<li class="skill-list-item">
														<h1>Taux de nicotine :</h1>
														<p class="skill-description">
															<?php echo $fetch_puff['nicotine'] . '&nbsp;%'; ?>
														</p>
													</li>
												</ul>
											</div>
										</div>
									</section>

									<input type="hidden" name="puff_id" value="<?php echo $fetch_puff['id']; ?>">
									<div class="button">
										<button type="submit" name="add_to_wishlist" class="btn">Ajouter à la liste de souhaits <i
												class="bx bx-heart"></i></button>
										<input type="hidden" name="qty" value="1" min="0" class="quantity">
										<button type="submit" name="add_to_cart" class="btn">Ajouter au panier <i
												class="bx bx-cart"></i></button>
									</div>
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