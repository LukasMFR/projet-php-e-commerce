<?php
include '../components/connection.php'; 

// Récupération du nom du puff et de la quantité totale vendue, groupées par ID de produit
$query = "SELECT p.name as product_name, SUM(o.qty) as total_quantity FROM orders o JOIN puff p ON o.product_id = p.id GROUP BY o.product_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
