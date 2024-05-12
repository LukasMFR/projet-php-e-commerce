<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: admin_login.php');
}

$get_id = $_GET['post_id'];

// Suppression du puff de la base de données
if (isset($_POST['delete'])) {
    $p_id = filter_var($_POST['post_id'], FILTER_SANITIZE_STRING);

    // Sélectionner les informations du puff pour supprimer l'image
    $select_image = $conn->prepare("SELECT image FROM `puff` WHERE id = ?");
    $select_image->execute([$p_id]);
    $image = $select_image->fetch(PDO::FETCH_ASSOC);

    // Supprimer le fichier image du serveur
    if (!empty($image['image'])) {
        unlink('../image/' . $image['image']);
    }

    // Supprimer le puff de la base de données
    $delete_post = $conn->prepare("DELETE FROM `puff` WHERE id = ?");
    $delete_post->execute([$p_id]);

    // Rediriger l'utilisateur vers la page de vue d'ensemble des puffs
    header('Location: view_posts_puff.php');
}
?>

<style>
    <?php include 'admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome cdn link  -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../img/favicon-64.png">
    <title>Voir le produit - Road Luxury</title>
</head>

<body>

    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Voir le produit</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Accueil </a><span>/ Voir le produit</span>
        </div>
        <section class="read-container">
            <?php
            if (isset($message) && is_array($message)) {
                foreach ($message as $msg) {
                    echo '
            <div class="message">
                <span>' . $msg . '</span>
                <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
            </div>
            ';
                }
            }
            ?>
            <div class="read-post">
                <?php
                $select_posts = $conn->prepare("SELECT * FROM `puff` WHERE id = ?");
                $select_posts->execute([$get_id]);
                if ($select_posts->rowCount() > 0) {
                    while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <form method="post">
                            <input type="hidden" name="post_id" value="<?= $fetch_posts['id']; ?>">
                            <div class="status"
                                style="background-color: <?= $fetch_posts['status'] == 'actif' ? 'limegreen' : 'coral'; ?>;">
                                <?= $fetch_posts['status']; ?>
                            </div>
                            <div class="image-box">
                                <!-- Affichage de l'image associée au puff -->
                                <?php if ($fetch_posts['image'] != '') { ?>
                                    <img src="../image/<?= $fetch_posts['image'] ?>" class="image puff">
                                <?php } ?>
                            </div>
                            <div class="title"><?= $fetch_posts['name'] ?></div>
                            <div class="content"><?= $fetch_posts['product_detail'] ?></div>
                            <div>Goût : <?= $fetch_posts['goût'] ?></div>
                            <div>Taffe : <?= $fetch_posts['taffe'] ?> taffes</div>
                            <div>Nicotine : <?= $fetch_posts['nicotine'] ?>%</div>
                            <div class="flex-btn">
                                <a href="edit_post_puff.php?id=<?= $fetch_posts['id']; ?>" class="btn">Modifier</a>
                                <button type="submit" name="delete" class="btn"
                                    onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
                                <a href="view_posts_puff.php" class="btn">Retour</a>
                            </div>
                        </form>
                        <?php
                    }
                } else {
                    echo '
            <div class="empty">
                <p>Aucun puff ajouté pour le moment ! <br><a href="add_posts_puff.php" class="btn" style="margin-top: 1.5rem;">Ajouter un puff</a></p>
            </div>
        ';
                }
                ?>
            </div>
        </section>
    </div>

    <script type="text/javascript" src="script.js"></script>
</body>

</html>