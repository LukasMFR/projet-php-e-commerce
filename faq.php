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
    <title>FAQ - Road Luxury</title>
    <?php include 'components/pwa-setup.php'; ?>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>FAQ</h1>
        </div>
        <div class="title2">
            <a href="home.php">accueil </a><span>/ faq</span>
        </div>

        <!-- Section FAQ -->
        <div class="faq-section">
            <h2>Questions Fréquemment Posées</h2>
            <div class="faq-item">
                <h3>Comment puis-je acheter une voiture chez Road Luxury?</h3>
                <p>Pour acheter une voiture, visitez notre page de collection ou contactez directement notre service
                    clientèle.</p>
            </div>
            <div class="faq-item">
                <h3>Quelles sont les garanties offertes sur les voitures?</h3>
                <p>Toutes nos voitures viennent avec une garantie complète de 12 mois.</p>
            </div>
            <div class="faq-item">
                <h3>Offrez-vous des livraisons internationales?</h3>
                <p>Oui, nous offrons des services de livraison partout dans le monde. Les tarifs varient selon la
                    destination.</p>
            </div>
            <div class="faq-item">
                <h3>Comment fonctionnent les retours?</h3>
                <p>Les retours sont acceptés dans les 30 jours suivant l'achat, à condition que la voiture soit dans le
                    même état qu'à la livraison.</p>
            </div>
            <div class="faq-item">
                <h3>Puis-je obtenir un puff en tant que goodie avec mon achat?</h3>
                <p>Oui, pour tout achat d'une voiture, un puff exclusif Road Luxury vous est offert.</p>
            </div>
            <div class="faq-item">
                <h3>En combien de temps la livraison est-elle effectuée?</h3>
                <p>Nous nous efforçons de livrer les voitures dans les délais les plus courts, habituellement sous 2 à 4
                    semaines selon la destination.</p>
            </div>
            <div class="faq-item">
                <h3>Y a-t-il une politique de remboursement en cas d'annulation?</h3>
                <p>Les clients peuvent annuler leur commande sous certaines conditions. Veuillez consulter nos termes et
                    conditions ou nous contacter pour plus d'informations.</p>
            </div>
            <div class="faq-item">
                <h3>Comment puis-je contacter Road Luxury pour des questions supplémentaires?</h3>
                <p>Si vous avez d'autres questions, n'hésitez pas à nous contacter via notre <a href="contact.php"
                        class="faq-contact-link">page de contact</a>. Notre équipe est prête à vous aider avec toutes
                    vos demandes.</p>
            </div>
        </div>


        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>

</html>