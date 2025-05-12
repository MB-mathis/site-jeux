<?php
session_start();
require_once "configbdd-pdo.php"; // Connexion à la base de données

$id = $_POST['id'] ?? null;
$jeu = ['nom' => '', 'genre' => '', 'type' => '', 'limite_age' => '']; // Valeurs par défaut

if ($id) {
    // Récupérer les infos du jeu pour modification
    $sql = "SELECT * FROM jeux WHERE id_jeux = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $jeu = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$jeu) {
        echo "Jeu introuvable.";
        exit();
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nom = $_POST['nom'];
    $genre = $_POST['genre'];
    $type = $_POST['type'];
    $limite_age = $_POST['limite_age'];

    if ($id) {
        // Mise à jour
        $sql = "UPDATE jeux SET nom = :nom, genre = :genre, type = :type, limite_age = :limite_age WHERE id_jeux = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id, ':nom' => $nom, ':genre' => $genre, ':type' => $type, ':limite_age' => $limite_age]);
        echo "Jeu mis à jour.";
    } else {
        // Ajout
        $sql = "INSERT INTO jeux (nom, genre, type, limite_age) VALUES (:nom, :genre, :type, :limite_age)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':nom' => $nom, ':genre' => $genre, ':type' => $type, ':limite_age' => $limite_age]);
        echo "Jeu ajouté.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? "Modifier le jeu" : "Ajouter un jeu" ?></title>
</head>
<body>

<h2><?= $id ? "Modifier le jeu" : "Ajouter un jeu" ?></h2>

<!-- Liens de navigation -->
<a href="accueil.php">⬅ Retour à l'accueil</a> |

<form method="POST" action="">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($jeu['id_jeux']) ?>">
    <?php endif; ?>

    <label for="nom">Nom :</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($jeu['nom']) ?>" required><br><br>

    <label for="genre">Genre :</label>
    <input type="text" name="genre" value="<?= htmlspecialchars($jeu['genre']) ?>" required><br><br>

    <label for="type">Type :</label>
    <input type="text" name="type" value="<?= htmlspecialchars($jeu['type']) ?>" required><br><br>

    <label for="limite_age">Âge limite :</label>
    <input type="number" name="limite_age" value="<?= htmlspecialchars($jeu['limite_age']) ?>" required><br><br>

    <input type="submit" value="<?= $id ? "Mettre à jour" : "Ajouter" ?>">
</form>

</body>
</html>
