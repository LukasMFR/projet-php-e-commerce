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

//adding products in cart
if (isset($_POST['add_to_cart'])) {
	$id = unique_id();
	$product_id = $_POST['product_id'];

	$qty = 1;
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

//adding puff in cart
if (isset($_POST['add_to_cart'])) {
	$id = unique_id();
	$puff_id = $_POST['puff_id'];

	$qty = 1;
	$qty = filter_var($qty, FILTER_SANITIZE_STRING);

	$varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND puff_id = ?");
	$varify_cart->execute([$user_id, $puff_id]);

	$max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
	$max_cart_items->execute([$user_id]);

	if ($varify_cart->rowCount() > 0) {
		$warning_msg[] = 'Le produit est déjà dans votre panier';
	} else if ($max_cart_items->rowCount() > 20) {
		$warning_msg[] = 'Le panier est plein';
	} else {
		$select_price = $conn->prepare("SELECT * FROM `puff` WHERE id = ? LIMIT 1");
		$select_price->execute([$puff_id]);
		$fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

		$insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id,puff_id,price,qty) VALUES(?,?,?,?,?)");
		$insert_cart->execute([$id, $user_id, $puff_id, $fetch_price['price'], $qty]);
		$success_msg[] = 'Produit ajouté avec succès au panier';
	}
}

//delete item from wishlist
if (isset($_POST['delete_item'])) {
	$wishlist_id = $_POST['wishlist_id'];
	$wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);

	$varify_delete_items = $conn->prepare("SELECT * FROM `wishlist` WHERE id =?");
	$varify_delete_items->execute([$wishlist_id]);

	if ($varify_delete_items->rowCount() > 0) {
		$delete_wishlist_id = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
		$delete_wishlist_id->execute([$wishlist_id]);
		$success_msg[] = "Article supprimé de la liste de souhaits avec succès";
	} else {
		$warning_msg[] = 'Article de la liste de souhaits déjà supprimé';
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
	<title>Liste de souhaits - Road Luxury</title>
	<?php include 'components/meta_tags.php'; ?>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Ma liste de souhaits</h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Ma liste de souhaits</span>
		</div>

		<section class="products">
		<h1>Voiture dans ma liste de souhaits</h1>
			<?php
			$grand_total = 0;
			$select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
			$select_wishlist->execute([$user_id]);
			if ($select_wishlist->rowCount() > 0) {
				echo '<div class="box-container wishlist-box-container">';

				while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
					$select_products = $conn->prepare("SELECT * FROM `products` WHERE id= ?");
					$select_products->execute([$fetch_wishlist['product_id']]);
					if ($select_products->rowCount() > 0) {
						$fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)

							?>

						<form method="post" action="" class="box product-view-form">
							<input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
							<div class="image-overlay">
								<img src="image/<?= $fetch_products['image']; ?>" class="img">
								<div class="button-group">
									<button type="submit" name="add_to_cart" class="icon-button"><i class="bx bx-cart"></i></button>
									<a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="icon-button"><i
											class="bx bxs-show"></i></a>
									<button type="submit" name="delete_item" class="icon-button"
										onclick="return confirm('Voulez-vous supprimer cet article de la liste de souhaits ?');"><i
											class="bx bx-x"></i></button>
								</div>
							</div>
							<div class="wishlist-info">
								<h3 class="name wishlist-name">
									<?= $fetch_products['name']; ?>
								</h3>
								<p class="price wishlist-price">Prix :
									<?= $fetch_products['price']; ?> €
								</p>
							</div>
							<input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
							<a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Acheter maintenant</a>
						</form>
						<?php
						 $grand_total += $fetch_wishlist['price'];
					}
				}
				echo '</div>';
			} else {
				echo '<div class="box-container"><p class="empty">Aucun produit ajouté pour le moment !</p></div>';
			}
			?>
		</section>

			<section class="products">
			<h1>Puff dans ma liste de souhaits</h1>
			<h1 class="title">Produits dans ma liste de souhaits</h1>
			<?php
			$grand_total = 0;
			$select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
			$select_wishlist->execute([$user_id]);
			if ($select_wishlist->rowCount() > 0) {
				echo '<div class="box-container wishlist-box-container">';

				while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
					$select_puff = $conn->prepare("SELECT * FROM `puff` WHERE id= ?");
					$select_puff->execute([$fetch_wishlist['puff_id']]);
					if ($select_puff->rowCount() > 0) {
						$fetch_puff = $select_puff->fetch(PDO::FETCH_ASSOC)

							?>

						<form method="post" action="" class="box product-view-form">
							<input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
							<div class="image-overlay">
								<img src="image/<?= $fetch_puff['image']; ?>" class="img">
								<div class="button-group">
									<button type="submit" name="add_to_cart" class="icon-button"><i class="bx bx-cart"></i></button>
									<a href="view_page_puffs.php?pid=<?php echo $fetch_puff['id']; ?>" class="icon-button"><i
											class="bx bxs-show"></i></a>
									<button type="submit" name="delete_item" class="icon-button"
										onclick="return confirm('Voulez-vous supprimer cet article de la liste de souhaits ?');"><i
											class="bx bx-x"></i></button>
								</div>
							</div>
							<div class="wishlist-info">
								<h3 class="name wishlist-name">
									<?= $fetch_puff['name']; ?>
								</h3>
								<p class="price wishlist-price">Prix :
									<?= $fetch_puff['price']; ?> €
								</p>
							</div>
							<input type="hidden" name="puff_id" value="<?= $fetch_puff['id']; ?>">
							<a href="checkout.php?get_id=<?= $fetch_puff['id']; ?>" class="btn">Acheter maintenant</a>
						</form>
						<?php
						$grand_total += $fetch_wishlist['price'];
					}
				}
				echo '</div>';
			} else {
				echo '<div class="box-container"><p class="empty">Aucun produit ajouté pour le moment !</p></div>';
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