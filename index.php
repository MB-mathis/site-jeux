<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur Apache</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: #2c3e50;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 5px 0;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur votre serveur Apache</h1>
    <p>Voici les fichiers disponibles dans ce répertoire :</p>
    <ul>
        <?php
        // Lister tous les fichiers dans le répertoire courant
        $files = scandir(__DIR__);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue; // Ignorer . et ..
            echo "<li><a href=\"$file\">$file</a></li>";
        }
        ?>
    </ul>
</body>
</html>
