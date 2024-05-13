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
if (isset($_GET['get_id']) && !empty($_GET['get_id'])) {
	$item_id = $_GET['get_id'];
	$item_type = $_GET['type'] ?? 'product';  // Default to 'product' if type is not specified

	// Fetch item details from the appropriate table based on type
	$table = ($item_type === 'puff') ? 'puff' : 'products';
	$select_item = $conn->prepare("SELECT * FROM `$table` WHERE id=? LIMIT 1");
	$select_item->execute([$item_id]);

	if ($fetch_item = $select_item->fetch(PDO::FETCH_ASSOC)) {
		// Prepare item details for checkout
		$item_for_checkout = [
			'item_id' => $item_id,
			'item_type' => $item_type,
			'price' => $fetch_item['price'],
			'qty' => 1  // Default quantity to 1 for direct checkout
		];
	} else {
		echo "<p>Item not found.</p>";
		exit;
	}
}

if (isset($_POST['place_order'])) {
	// Sanitize and validate input data
	$name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$number = filter_var($_POST['number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$address = filter_var($_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pincode'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$method = filter_var($_POST['method'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	// Direct checkout if item_id is passed via URL
	if (!empty($item_for_checkout)) {
		$insert_order = $conn->prepare("INSERT INTO `orders`(id, user_id, name, number, email, address, address_type, method, item_id, item_type, price, qty, payment_status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?, 'en attente')");
		$insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $item_for_checkout['item_id'], $item_for_checkout['item_type'], $item_for_checkout['price'], $item_for_checkout['qty']]);
		header('location: order.php');
		exit;
	}

	// Handle checkout from the cart if no direct item is checked out
	$verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
	$verify_cart->execute([$user_id]);

	if ($verify_cart->rowCount() > 0) {
		while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
			$insert_order = $conn->prepare("INSERT INTO `orders`(id, user_id, name, number, email, address, address_type, method, item_id, item_type, price, qty, payment_status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?, 'en attente')");
			$insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $f_cart['item_id'], $f_cart['item_type'], $f_cart['price'], $f_cart['qty']]);
		}
		$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
		$delete_cart->execute([$user_id]);
		header('location: order.php');
		exit;
	} else {
		echo '<p>Your cart is empty.</p>';
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
	<title>Page de paiement - Road Luxury</title>
	<?php include 'components/pwa-setup.php'; ?>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Résumé de la commande</h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Résumé de la commande</span>
		</div>
		<section class="checkout">
			<div class="title">
				<!-- <img src="img/download.png" class="logo"> -->
				<!-- <h1>Résumé de la commande</h1> -->
				<p>Découvrez la simplicité et la sécurité de finaliser votre commande avec nous. Remplissez simplement
					vos informations ci-dessous.</p>
			</div>
			<div class="row">
				<form method="post">
					<h3>Détails de facturation</h3>
					<div class="flex">
						<div class="box">
							<div class="input-field">
								<p>Votre nom <span>*</span></p>
								<input type="text" name="name" required maxlength="50" placeholder="Saisir votre nom"
									class="input">
							</div>
							<div class="input-field">
								<p>Votre numéro <span>*</span></p>
								<input type="number" name="number" required maxlength="10"
									placeholder="Saisir votre numéro" class="input">
							</div>
							<div class="input-field">
								<p>Votre email <span>*</span></p>
								<input type="email" name="email" required maxlength="50"
									placeholder="Saisir votre email" class="input">
							</div>
							<div class="input-field">
								<p>Méthode de paiement <span>*</span></p>
								<select name="method" class="input">
									<option value="cash on delivery">Paiement à la livraison</option>
									<option value="credit or debit card">Carte de crédit ou de débit</option>
									<option value="net banking">Banque en ligne</option>
									<option value="UPI or RuPay">UPI ou RuPay</option>
									<option value="paytm">Paytm</option>
								</select>
							</div>
							<div class="input-field">
								<p>Type d'adresse <span>*</span></p>
								<select name="address_type" class="input">
									<option value="home">Domicile</option>
									<option value="office">Bureau</option>

								</select>
							</div>
						</div>
						<div class="box">
							<div class="input-field">
								<p>Adresse ligne 01 <span>*</span></p>
								<input type="text" name="flat" required maxlength="50"
									placeholder="Ex. : numéro d'appartement et d'immeuble" class="input">
							</div>
							<div class="input-field">
								<p>Adresse ligne 02 <span>*</span></p>
								<input type="text" name="street" required maxlength="50"
									placeholder="Ex. : nom de la rue" class="input">
							</div>
							<div class="input-field">
								<p>Ville <span>*</span></p>
								<input type="text" name="city" required maxlength="50" placeholder="Saisir la ville"
									class="input">
							</div>
							<div class="input-field">
								<p>Pays <span>*</span></p>
								<input type="text" name="country" required maxlength="50" placeholder="Saisir le pays"
									class="input">
							</div>
							<div class="input-field">
								<p>Code postal <span>*</span></p>
								<input type="text" name="pincode" required maxlength="6" placeholder="75000" min="0"
									max="999999" class="input">
							</div>
						</div>
					</div>
					<button type="submit" name="place_order" class="btn">Passer la commande</button>
				</form>
				<div class="summary">
					<h3>Mon panier</h3>
					<div class="box-container">
						<?php
						$grand_total = 0;

						if (isset($_GET['get_id']) && isset($_GET['type'])) {
							$item_id = $_GET['get_id'];
							$item_type = $_GET['type'];
							$table = ($item_type === 'puff') ? 'puff' : 'products';
							$select_item = $conn->prepare("SELECT * FROM `$table` WHERE id=? LIMIT 1");
							$select_item->execute([$item_id]);

							if ($fetch_item = $select_item->fetch(PDO::FETCH_ASSOC)) {
								$sub_total = $fetch_item['price'];  // Assuming the quantity is 1 for direct checkout
								$grand_total += $sub_total;
								?>
								<div class="flex">
									<img src="image/<?= $fetch_item['image']; ?>" class="image">
									<div>
										<h3 class="name"><?= $fetch_item['name']; ?></h3>
										<p class="price">
											<?= number_format($fetch_item['price'], 2, ',', '&nbsp;') . '&nbsp;€'; ?>
										</p>
										<p class="quantity">Quantité : 1</p>
									</div>
								</div>
								<?php
							} else {
								echo '<p class="empty">Item not found.</p>';
							}
						} else {
							$select_cart = $conn->prepare("SELECT c.*, IF(c.item_type='product', p.price, f.price) AS price, IF(c.item_type='product', p.name, f.name) AS name, IF(c.item_type='product', p.image, f.image) AS image FROM `cart` c LEFT JOIN `products` p ON c.item_id = p.id AND c.item_type='product' LEFT JOIN `puff` f ON c.item_id = f.id AND c.item_type='puff' WHERE c.user_id=?");
							$select_cart->execute([$user_id]);

							if ($select_cart->rowCount() > 0) {
								while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
									$sub_total = ($fetch_cart['qty'] * $fetch_cart['price']);
									$grand_total += $sub_total;
									?>
									<div class="flex">
										<img src="image/<?= $fetch_cart['image']; ?>" class="image">
										<div>
											<h3 class="name"><?= $fetch_cart['name']; ?></h3>
											<p class="price">
												<?= number_format($fetch_cart['price'], 2, ',', '&nbsp;') . '&nbsp;€'; ?>
											</p>
											<p class="quantity">Quantité : <?= $fetch_cart['qty']; ?></p>
										</div>
									</div>
									<?php
								}
							} else {
								echo '<p class="empty">Votre panier est vide</p>';
							}
						}
						?>
					</div>
					<div class="grand-total"><span>Montant total à payer :
						</span><?= number_format($grand_total, 2, ',', '&nbsp;') . '&nbsp;€'; ?></div>
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