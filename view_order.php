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

if (isset($_GET['get_id'])) {
	$get_id = $_GET['get_id'];
} else {
	header('location:order.php');
	exit;
}

if (isset($_POST['cancel'])) {
	$update_order = $conn->prepare("UPDATE `orders` SET status = 'annulee' WHERE id=?");
	$update_order->execute([$get_id]);
	header('location:order.php');
	exit;
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="img/favicon-64.png">
	<title>Détail de la commande - Road Luxury</title>
	<?php include 'components/meta_tags.php'; ?>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Détail de la commande</h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Détail de la commande</span>
		</div>
		<section class="order-detail">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Détail de la commande</h1>
				<p class="order-description">Retrouvez ici tous les détails de votre commande, y compris les
					informations sur le produit, le montant total et le statut de livraison.</p>
			</div>
			<div class="box-container">
				<?php
				$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id=? LIMIT 1");
				$select_orders->execute([$get_id]);
				if ($select_orders->rowCount() > 0) {
					while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
						$table = ($fetch_order['item_type'] === 'puff') ? 'puff' : 'products';
						$select_item = $conn->prepare("SELECT * FROM `$table` WHERE id=? LIMIT 1");
						$select_item->execute([$fetch_order['item_id']]);

						if ($select_item->rowCount() > 0) {
							while ($fetch_item = $select_item->fetch(PDO::FETCH_ASSOC)) {
								$sub_total = ($fetch_order['price'] * $fetch_order['qty']);
								?>
								<div class="box">
									<div class="product-details">
										<p class="date"><i class="bi bi-calendar-fill"></i>
											<?php
											$date = strtotime($fetch_order['date']);
											$formattedDate = date('d ', $date) . $mois[date('F', $date)] . date(' Y à H:i', $date);
											echo $formattedDate;
											?>
										</p>
										<img src="image/<?= $fetch_item['image']; ?>" class="image">
										<div class="product-info">
											<p class="price"><?= number_format($fetch_item['price'], 2, ',', ' '); ?> €</p>
											<p class="quantity">Quantité : <?= $fetch_order['qty']; ?></p>
											<h3 class="name"><?= $fetch_item['name']; ?></h3>
											<p class="grand-total">Montant total : <span><?= number_format($sub_total, 2, ',', ' '); ?>
													€</span></p>
										</div>
									</div>
									<div class="billing-info">
										<p class="title">Informations de facturation</p>
										<div class="user-details">
											<p class="user"><i class="bi bi-person-bounding-box"></i><?= $fetch_order['name']; ?></p>
											<p class="user"><i class="bi bi-phone"></i><?= $fetch_order['number']; ?></p>
											<p class="user"><i class="bi bi-envelope"></i><?= $fetch_order['email']; ?></p>
											<p class="user"><i class="bi bi-pin-map-fill"></i><?= $fetch_order['address']; ?></p>
											<p class="status">Statut : <span
													data-status="<?= strtolower($fetch_order['status']); ?>"><?= $fetch_order['status']; ?></span>
											</p>
										</div>
										<?php if ($fetch_order['status'] == 'annulee') { ?>
											<a href="checkout.php?get_id=<?= $fetch_item['id']; ?>&type=<?= $fetch_order['item_type']; ?>"
												class="btn">Commander à nouveau</a>
										<?php } else { ?>
											<form method="post">
												<button type="submit" name="cancel" class="btn"
													onclick="return confirm('Voulez-vous annuler cette commande ?')">Annuler la
													commande</button>
											</form>
										<?php } ?>
									</div>
								</div>
								<?php
							}
						} else {
							echo '<p class="empty">Produit non trouvé</p>';
						}
					}
				} else {
					echo '<p class="empty">Aucune commande trouvée</p>';
				}
				?>
			</div>

		</section>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>

</html>