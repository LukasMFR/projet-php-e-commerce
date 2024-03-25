<!-- index.php -->
<html lang="fr">
<head>
    <title>PHP Test</title>
</head>
<body>
    <h1>PHP E-commerce</h1>
    <p>This is a test of PHP code.</p>

    <?php
    echo "Hello, World!";
    echo "<br>";
    echo "The current server time is: " . date('Y-m-d H:i:s');
    echo "<br>";
    echo $_SERVER['HTTP_USER_AGENT'];

    echo "<br>";
    echo "Je suis un test de code PHP ! Lukas";

    echo "<br>";

    for ($i = 0; $i < 10; $i++) {
        echo "i = $i<br>";
    }
    ?>
</body>