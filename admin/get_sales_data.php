<?php
include '../components/connection.php';  

$query = "SELECT p.name as product_name, SUM(o.qty) as total_quantity FROM orders o JOIN products p ON o.product_id = p.id GROUP BY o.product_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>

