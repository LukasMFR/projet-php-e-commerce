<?php
include '../components/connection.php'; 

$query = "SELECT p.name AS product_name, SUM(o.qty) AS total_quantity FROM orders o JOIN puff p ON o.puff_id = p.id GROUP BY o.puff_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
