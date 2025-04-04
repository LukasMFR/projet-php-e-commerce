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

// Update product quantity in cart
if (isset($_POST['update_cart'])) {
	$cart_id = $_POST['cart_id'];
	$cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
	$qty = $_POST['qty'];
	$qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);  // Sanitize as integer

	if ($qty > 0) {  // Ensure the quantity is positive
		$update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
		$update_qty->execute([$qty, $cart_id]);
		$success_msg[] = 'Quantité dans le panier mise à jour avec succès';
	} else {
		$warning_msg[] = 'Quantité invalide';
	}
}

// Delete item from cart
if (isset($_POST['delete_item'])) {
	$cart_id = $_POST['cart_id'];
	$cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

	$delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
	$delete_cart_item->execute([$cart_id]);
	if ($delete_cart_item->rowCount() > 0) {
		$success_msg[] = "Article supprimé du panier";
	} else {
		$warning_msg[] = 'Article déjà supprimé ou inexistant';
	}
}

// Empty cart
if (isset($_POST['empty_cart'])) {
	$delete_all_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
	$delete_all_cart_items->execute([$user_id]);
	if ($delete_all_cart_items->rowCount() > 0) {
		$success_msg[] = "Panier vidé avec succès";
	} else {
		$warning_msg[] = 'Le panier est déjà vide';
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
	<title>Mon panier - Road Luxury</title>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div id="cart-page" class="main cart-page">
		<div class="banner">
			<h1>Mon panier</h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Panier</span>
		</div>
		<section class="products">
			<h1 class="title cart">Produits ajoutés au panier</h1>
			<div class="box-container cart-page">
				<?php
				$grand_total = 0;
				$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
				$select_cart->execute([$user_id]);
				if ($select_cart->rowCount() > 0) {
					while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
						$table_name = $fetch_cart['item_type'] === 'product' ? 'products' : 'puff';
						$select_products = $conn->prepare("SELECT * FROM `$table_name` WHERE id = ?");
						$select_products->execute([$fetch_cart['item_id']]);
						if ($select_products->rowCount() > 0) {
							$fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
							?>
							<form method="post" action="" class="box">
								<input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
								<img src="image/<?= $fetch_products['image']; ?>" class="img">
								<h3 class="name"><?= $fetch_products['name']; ?></h3>
								<div class="flex">
									<p class="price">Prix :
										<?= number_format($fetch_products['price'], 2, ',', '&nbsp;') . '&nbsp;€'; ?>
									</p>
									<input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99"
										maxlength="2" class="qty">
									<button type="submit" name="update_cart" class="bx bxs-edit fa-edit"></button>
								</div>
								<p class="sub-total">Sous-total :
									<span><?= number_format($sub_total = ($fetch_cart['qty'] * $fetch_cart['price']), 2, ',', '&nbsp;') . '&nbsp;€'; ?></span>
								</p>
								<button type="submit" name="delete_item" class="btn"
									onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
							</form>
							<?php
							$grand_total += $sub_total;
						} else {
							echo '<p class="empty">Produit non trouvé</p>';
						}
					}
				} else {
					echo '<p class="empty">Aucun produit ajouté !</p>';
				}
				?>
			</div>
			<?php
			if ($grand_total != 0) {
				?>
				<div class="cart-total">
					<p>Total à payer : <span><?= number_format($grand_total, 2, ',', '&nbsp;') . '&nbsp;€'; ?></span></p>
					<div class="button">
						<form method="post">
							<button type="submit" name="empty_cart" class="btn"
								onclick="return confirm('Voulez-vous vider le panier ?')">Vider le panier</button>
						</form>
						<a href="checkout.php" class="btn">Procéder au paiement</a>
					</div>
				</div>
			<?php } ?>
		</section>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>

</html>