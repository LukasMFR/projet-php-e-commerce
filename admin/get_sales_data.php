<?php
include '../components/connection.php';

// Requête mise à jour pour intégrer item_id et item_type
$query = "SELECT p.name AS product_name, SUM(o.qty) AS total_quantity 
          FROM orders o 
          JOIN products p ON o.item_id = p.id AND o.item_type = 'product' 
          GROUP BY o.item_id";

$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>