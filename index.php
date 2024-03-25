<!-- index.php -->
<html lang="fr">
<head>
    <title>AutoCar</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <h1>AutoCar</h1>
    <p>Site web de AutoCar</p>

    <?php
    echo "Hello, World!";
    echo "<br>";
    echo "The current server time is: " . date('Y-m-d H:i:s');
    echo "<br>";
    echo $_SERVER['HTTP_USER_AGENT'];
    ?>
</body>
</html>
