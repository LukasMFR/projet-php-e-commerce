<?php

include '../components/connection.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location: admin_login.php');
}


//delete products from database
//delete order
if (isset($_POST['delete_order'])) {
	$delete_id = $_POST['order_id'];
	$delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

	$verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
	$verify_delete->execute([$delete_id]);

	if ($verify_delete->rowCount() > 0) {
		$delete_review = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
		$delete_review->execute([$delete_id]);
		$success_msg[] = "Commande supprimée";
	} else {
		$warning_msg[] = 'Commande déjà supprimée';
	}
}

//updateing payment status
if (isset($_POST['update_order'])) {
	$order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
	$update_payment = filter_var($_POST['update_payment'], FILTER_SANITIZE_STRING);

	$update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
	$update_pay->execute([$update_payment, $order_id]);
	$success_msg[] = 'Commande mise à jour';
}

?>
<style type="text/css">
	<?php
	include 'admin_style.css';

	?>
</style>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--box icon link-->
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="../img/favicon-64.png">
	<title>Commandes - Road Luxury</title>
</head>

<body>

	<?php include '../components/admin_header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Total des commandes passées</h1>
		</div>
		<div class="title2">
			<a href="dashboard.php">Accueil </a><span>/ Total des commandes</span>
		</div>
		<section class="order-container">
			<h1 class="heading">Total des commandes passées</h1>
			<div class="box-container">
				<?php
				$select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY date DESC");
				$select_orders->execute();
				if ($select_orders->rowCount() > 0) {
					while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
						?>
						<div class="box">
							<div class="status"
								style="color: <?= $fetch_orders['status'] == 'en cours' ? 'limegreen' : 'coral'; ?>;">
								<?= $fetch_orders['status'] ?>
							</div>
							<div class="detail">
								<p>Nom de l'utilisateur : <span><?= $fetch_orders['name']; ?></span></p>
								<p>ID de l'utilisateur : <span><?= $fetch_orders['user_id']; ?></span></p>
								<p>Placée le : <span><?= $fetch_orders['date']; ?></span></p>
								<p>Numéro : <span><?= $fetch_orders['number']; ?></span></p>
								<p>Email : <span><?= $fetch_orders['email']; ?></span></p>
								<p>Prix total : <span><?= $fetch_orders['price']; ?></span></p>
								<p>Méthode : <span><?= $fetch_orders['method']; ?></span></p>
								<p>Adresse : <span><?= $fetch_orders['address']; ?></span></p>
							</div>
							<form method="post">
								<input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
								<select name="update_payment">
									<option disabled selected><?= $fetch_orders['payment_status']; ?></option>
									<option value="en attente">en attente</option>
									<option value="completee">completee</option>
								</select>
								<div class="flex-btn">
									<input type="submit" name="update_order" value="Mettre à jour le paiement" class="btn">
									<input type="submit" name="delete_order" value="Supprimer la commande" class="btn"
										onclick="return confirm('Supprimer cette commande ?');">
								</div>
							</form>
						</div>
						<?php
					}
				} else {
					echo '<div class="empty"><p>Aucune commande passée pour le moment !</p></div>';
				}
				?>
			</div>
		</section>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include '../components/alert.php'; ?>

</body>

</html>