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
//adding pu in wishlist
if (isset($_POST['add_to_wishlist'])) {
    $id = unique_id();
    $product_id = $_POST['puff_id'];

    $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $varify_wishlist->execute([$user_id, $puff_id]);

    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $pufff_id]);

    if ($varify_wishlist->rowCount() > 0) {
        $warning_msg[] = 'Le produit est déjà dans votre liste de souhaits';
    } else if ($cart_num->rowCount() > 0) {
        $warning_msg[] = 'Le produit est déjà dans votre panier';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `puff` WHERE id = ? LIMIT 1");
        $select_price->execute([$puff_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id, user_id,puff_id,price) VALUES(?,?,?,?)");
        $insert_wishlist->execute([$id, $user_id, $puff_id, $fetch_price['price']]);
        $success_msg[] = 'Produit ajouté avec succès à la liste de souhaits';
    }
}
//adding pu in cart
if (isset($_POST['add_to_cart'])) {
    $id = unique_id();
    $product_id = $_POST['puff_id'];

    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
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
    <title>Puffs - Road Luxury</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Puffs</h1>
        </div>
        <div class="title2">
            <a href="home.php">Accueil </a><span>/ Puffs</span>
        </div>

        <section class="products">
            <div class="box-container">
                <?php
                $select_puff= $conn->prepare("SELECT * FROM `puff` WHERE `status` = 'actif'");
                $select_puff->execute();
                if ($select_puff->rowCount() > 0) {
                    while ($fetch_puff = $select_puff->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <form action="" method="post" class="box product-view-form">
                            <div class="image-container">
                                <img src="image/<?= htmlspecialchars($fetch_puff['image']); ?>" class="img">
                                <a href="view_page_puffs.php?pid=<?= htmlspecialchars($fetch_puff['id']); ?>"
                                    class="view-btn">Visualiser</a>
                                <div class="button special-button">
                                    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                </div>
                            </div>
                            <input type="hidden" name="puff_id" value="<?= htmlspecialchars($fetch_puff['id']); ?>">
                            <h1><?= htmlspecialchars($fetch_puff['name']); ?></h1>
                        </form>
                        <?php
                    }
                } else {
                    echo '<p class="empty">Aucun produit ajouté pour le moment !</p>';
                }
                ?>
            </div>

            <div class="title-product">
                <img src="img/download.png" class="logo-small">
                <h1>Bientôt disponible</h1>
            </div>
            <div class="box-container">
                <?php
                $select_puff= $conn->prepare("SELECT * FROM `puff ` WHERE `status` = 'inactif'");
                $select_puff->execute();
                if ($select_puff->rowCount() > 0) {
                    while ($fetch_puff = $select_puff->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <form action="" method="post" class="box product-view-form">
                            <div class="image-container">
                                <img src="image/<?= htmlspecialchars($fetch_puff['image']); ?>" class="img">
                                <a href="view_page_puffs.php?pid=<?= htmlspecialchars($fetch_puff['id']); ?>"
                                    class="view-btn">Visualiser</a>
                                <div class="button special-button">
                                    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                </div>
                            </div>
                            <input type="hidden" name="puff_id" value="<?= htmlspecialchars($fetch_puff['id']); ?>">
                            <h1><?= htmlspecialchars($fetch_puff['name']); ?></h1>
                        </form>
                        <?php
                    }
                } else {
                    echo '<p class="empty">Aucun produit ajouté pour le moment !</p>';
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