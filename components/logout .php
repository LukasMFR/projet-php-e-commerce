<?php
include 'components/connection.php';

if (headers_sent($file, $line)) {
    echo "Les en-têtes ont été envoyés dans $file à la ligne $line";
} else {
    session_start();
    session_unset();
    session_destroy();
    header('Location: /projet-php-e-commerce/home.php');
    exit;
}
?>