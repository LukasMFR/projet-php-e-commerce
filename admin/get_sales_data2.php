<?php
include '../components/connection.php';

// Exemple de requête pour obtenir des ventes par région
$query = "SELECT p.name AS product_name, SUM(o.qty) AS total_quantity 
          FROM orders o 
          JOIN products p ON o.item_id = p.id AND o.item_type = 'product' 
          GROUP BY o.item_id";

$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
