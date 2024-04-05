<header class="header">
	<div class="flex">
		<a href="home.php" class="brand-navbar">
			<div class="logo"><img src="img/logoLeg.png" alt="Road Luxury Logo"></div>
			<h1>Road Luxury</h1>
		</a>
		<nav class="navbar">
			<a href="home.php">Accueil</a>
			<a href="view_products.php">Produits</a>
			<a href="order.php">Commandes</a>
			<a href="about.php">À propos</a>
			<a href="contact.php">Nous contacter</a>
		</nav>
		<div class="icons">
			<i class="bx bxs-user" id="user-btn"></i>
			<?php
			$count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
			$count_wishlist_items->execute([$user_id]);
			$total_wishlist_items = $count_wishlist_items->rowCount();
			?>
			<a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup>
					<?= $total_wishlist_items ?>
				</sup></a>
			<?php
			$count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
			$count_cart_items->execute([$user_id]);
			$total_cart_items = $count_cart_items->rowCount();
			?>
			<a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup>
					<?= $total_cart_items ?>
				</sup></a>
			<i class='bx bx-list-plus' id="menu-btn" style="font-size: 2rem;"></i>
		</div>
		<div class="user-box">
			<?php
			if (isset($_SESSION['user_id'])) {
				?>
				<p>Nom d'utilisateur : <span>
						<?php echo $_SESSION['user_name']; ?>
					</span></p>
				<p>Email : <span>
						<?php echo $_SESSION['user_email']; ?>
					</span></p>
				<form method="post">
					<button type="submit" name="logout" class="logout-btn">Se déconnecter</button>
				</form>

				<?php
			} else {
				?>

				<h3 style="margin-bottom: 1rem">Se connecter ou s'enregistrer</h3>
				<div class="flex-btn">
					<a href="login.php" class="btn">Se connecter</a>
					<a href="register.php" class="btn">S'enregistrer</a>
				</div>
				<?php
			}
			?>

		</div>
	</div>
</header>