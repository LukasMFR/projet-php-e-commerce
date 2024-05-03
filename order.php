<?php
include 'components/connection.php';
session_start();

// Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
if (!isset($_SESSION['user_id'])) {
	header("Location: order.php");
	exit;
}

// Code pour afficher le message de bienvenue avec SweetAlert
if (isset($_SESSION['welcome_login'])) {
	echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
	echo "<script>
        Swal.fire({
            title: 'Bienvenue !',
            text: 'Vous êtes maintenant connecté(e).',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>";
	unset($_SESSION['welcome_login']); // Supprimez la variable après l'affichage pour éviter que le message ne réapparaisse lors des chargements futurs de la page.
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['logout'])) {
	session_destroy();
	header("Location: login.php");
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
	<title>Page des commandes - Road Luxury</title>
</head>

<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner commande">
			<h1></h1>
		</div>
		<div class="title2">
			<a href="home.php">Accueil </a><span>/ Mes commandes</span>
		</div>
		<section class="orders">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>Mes commandes</h1>
				<p>Voir mes commandes</p>
			</div>
			<div class="box-container">
				<?php
				$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
				$select_orders->execute([$user_id]);
				if ($select_orders->rowCount() > 0) {
					while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
						$table = ($fetch_order['item_type'] === 'puff') ? 'puff' : 'products';
						$select_item = $conn->prepare("SELECT * FROM `$table` WHERE id=?");
						$select_item->execute([$fetch_order['item_id']]);

						if ($select_item->rowCount() > 0) {
							while ($fetch_item = $select_item->fetch(PDO::FETCH_ASSOC)) {
								?>
								<div class="box">
									<a href="view_order.php?get_id=<?= $fetch_order['id']; ?>">
										<div class="date">
											<i class="bi bi-calendar-fill"></i>
											<span>
												<?php
												$date = strtotime($fetch_order['date']);
												$formattedDate = date('d ', $date) . $mois[date('F', $date)] . date(' Y à H:i', $date);
												echo $formattedDate;
												?>
											</span>
										</div>
										<img src="image/<?= $fetch_item['image']; ?>"
											class="<?= $fetch_order['item_type'] === 'product' ? 'car-image' : 'puff-image'; ?>"
											alt="Product Image">
										<div class="info">
											<h3 class="name"><?= $fetch_item['name']; ?></h3>
											<p class="price">Prix : <?= number_format($fetch_order['price'], 2, ',', ' '); ?> € x
												<?= $fetch_order['qty']; ?>
											</p>
											<p class="status" data-status="<?= $fetch_order['status']; ?>">
												<?= $fetch_order['status']; ?>
											</p>
										</div>
									</a>
								</div>
								<?php
							}
						} else {
							echo '<p class="empty">Item details not found.</p>';
						}
					}
				} else {
					echo '<p class="empty">Aucune commande passée pour le moment !</p>';
				}
				?>
			</div>
		</section>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>