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

$search_term = $_GET['search'] ?? '';  // Default to an empty string if 'search' is not in the query string
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            margin: 20px;
            text-align: center;
        }

        input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: #f9f9f9;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
        }
    </style>
    <?php include 'components/pwa-setup.php'; ?>
</head>

<body>
    <form method="GET" action="search.php">
        <input type="text" name="search" placeholder="Search for cars or puffs..."
            value="<?= htmlspecialchars($search_term); ?>">
        <button type="submit">Search</button>
    </form>

    <?php
    if (!empty($search_term)) {
        $query = $conn->prepare("SELECT 'Car' as type, id, name, price, image, Modèle, Année, moteur, kilométrage FROM products WHERE name LIKE ? OR Modèle LIKE ? OR moteur LIKE ? UNION ALL SELECT 'Puff' as type, id, name, price, image, goût as Modèle, '' as Année, '' as moteur, taffe as kilométrage FROM puff WHERE name LIKE ? OR goût LIKE ?");
        $search_term_like = "%{$search_term}%";
        $query->execute([$search_term_like, $search_term_like, $search_term_like, $search_term_like, $search_term_like]);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($query->rowCount() > 0) {
            echo '<ul>';
            foreach ($results as $item) {
                echo "<li>{$item['type']}: {$item['name']} - {$item['price']} € - Model/Flavor: {$item['Modèle']} - Year/Taffe: {$item['Année']}{$item['moteur']} - Mileage/Nicotine: {$item['kilométrage']}</li>";
            }
            echo '</ul>';
        } else {
            echo '<p>No results found.</p>';
        }
    }
    ?>
</body>

</html>