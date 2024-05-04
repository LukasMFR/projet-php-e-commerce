<?php
if (!isset($_SESSION)) {
	session_start();  // Assurez-vous que la session est démarrée
}
// Initialiser $user_id à partir de la session ou à NULL si non disponible
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

require_once ('connection.php');

?>

<header class="header">
	<div class="flex">
		<a href="home.php" class="brand-navbar">
			<div class="logo"><img src="img/rounded_logo.png" alt="Road Luxury Logo"></div>
			<h1>Road Luxury</h1>
		</a>
		<nav class="navbar">
			<a href="view_products.php">Voitures</a>
			<a href="view_puffs.php">Vapes</a>
			<?php if (isset($_SESSION['user_id'])): ?>
				<a href="order.php">Commandes</a>
			<?php endif; ?>
			<a href="about.php">À propos</a>
			<a href="contact.php">Nous contacter</a>
		</nav>
		<div class="icons">
			<i class="bx bxs-user" id="user-btn"></i>
			<?php
			$count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
			$count_wishlist_items->execute([$user_id]);
			$total_wishlist_items = $count_wishlist_items->rowCount();
			if ($total_wishlist_items > 0) {
				echo '<a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup>' . $total_wishlist_items . '</sup></a>';
			} else {
				echo '<a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i></a>';
			}
			$count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
			$count_cart_items->execute([$user_id]);
			$total_cart_items = $count_cart_items->rowCount();
			if ($total_cart_items > 0) {
				echo '<a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup>' . $total_cart_items . '</sup></a>';
			} else {
				echo '<a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i></a>';
			}
			?>
			<i class='bx bx-list-plus' id="menu-btn" style="font-size: 2rem;"></i>
		</div>

		<div class="user-box">
			<?php if (isset($_SESSION['user_id'])): ?>
				<?php
				$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
				$select_profile->execute([$_SESSION['user_id']]);
				if ($select_profile->rowCount() > 0) {
					$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
					if (!empty($fetch_profile['profile'])) {
						$profileImage = "image/" . $fetch_profile['profile'];
						echo "<img src='$profileImage' class='logo-image' width='100'>";
					} else {
						// Utilisez la classe `user-icon-default` pour appliquer le style
						echo "<div class='user-icon-default'><i class='bx bxs-user'></i></div>";
					}
					?>
					<p><?= $fetch_profile['name']; ?></p>
					<div class="flex-btn">
						<a href="update_user.php" class="btn">Mettre à jour le profil</a>
						<form method="post" action="components/logout.php">
							<button type="submit" name="logout" class="btn">Se déconnecter</button>
						</form>
					</div>
					<?php
				} else {
					echo "<p>Profil non trouvé.</p>";
				}
				?>
			<?php else: ?>
				<!-- Code pour les utilisateurs non connectés -->
				<div class="flex-btn flex-btn-inline">
					<a href="login.php" class="btn">Se connecter</a>
					<a href="register.php" class="btn">S'enregistrer</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</header>