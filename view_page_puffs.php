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
//adding puff in wishlist
if (isset($_POST['add_to_wishlist'])) {
	$id = unique_id();
	$puff_id = $_POST['puff_id'];

	$varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND puff_id = ?");
	$varify_wishlist->execute([$user_id, $puff_id]);

	$cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND puff_id = ?");
	$cart_num->execute([$user_id, $puff_id]);

	if ($varify_wishlist->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre liste de souhaits';
	} else if ($cart_num->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre panier';
	} else {
		$select_price = $conn->prepare("SELECT * FROM `puff` WHERE id = ? LIMIT 1");
		$select_price->execute([$puff_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		$insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id,puff_id,price) VALUES(?,?,?,?)");
		$insert_wishlist->execute([$id, $user_id, $puff_id, $fetch_price['price']]);
		$success_msg[] = 'Produit ajouté à la liste de souhaits avec succès';
	}
}
//adding puff in cart
if (isset($_POST['add_to_cart'])) {
	$id = unique_id();
	$puff_id = $_POST['puff_id'];

	$qty = $_POST['qty'];
	$qty = filter_var($qty, FILTER_SANITIZE_STRING);

	$varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND puff_id = ?");
	$varify_cart->execute([$user_id, $puff_id]);

	$max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
	$max_cart_items->execute([$user_id]);

	if ($varify_cart->rowCount() > 0) {
		$warning_msg[] = 'Le produit existe déjà dans votre panier';
	} else if ($max_cart_items->rowCount() > 20) {
		$warning_msg[] = 'Le panier est plein';
	} else {
		$select_price = $conn->prepare("SELECT * FROM `puff` WHERE id = ? LIMIT 1");
		$select_price->execute([$puff_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		$insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id,puff_id,price,qty) VALUES(?,?,?,?,?)");
		$insert_cart->execute([$id, $user_id, $puff_id, $fetch_price['price'], $qty]);
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
				$select_puff = $conn->prepare("SELECT * FROM `puff` WHERE id = ?");
				$select_puff->execute([$pid]);
				if ($select_puff->rowCount() > 0) {
					while ($fetch_puff = $select_puff->fetch(PDO::FETCH_ASSOC)) {
						?>

						<form method="post">
							<div class="product-images">
								<img src="image/<?php echo $fetch_puff['image']; ?>" alt="Image principale">
								<div class="image-container">
							</div>
							</div>
							<div class="detail">
								<div class="price"><?php echo $fetch_puff['price']; ?> €</div>
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
													<h1>Saveur:</h1>
													<p class="skill-description"><?php echo $fetch_puff['goût']; ?>
													</p>
												</li>
												<li class="skill-list-item">
													<h1>Nombre de taffe:</h1>
													<p class="skill-description"><?php echo $fetch_puff['taffe']; ?></p>
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