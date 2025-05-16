<?php
session_start();
require_once "configbdd-pdo.php"; // Connexion à la base de données

$id = $_POST['id'] ?? $_GET['id'] ?? null;
$jeu = ['nom' => '', 'genre' => '', 'type' => '', 'limite_age' => '', 'image' => '']; // Valeurs par défaut

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
    $nom = htmlspecialchars($_POST['nom']);  // Assainir les entrées
    $genre = htmlspecialchars($_POST['genre']);
    $type = htmlspecialchars($_POST['type']);
    $limite_age = $_POST['limite_age'];
    $imageName = null;

    // Correction : vérifier si un fichier a été uploadé et qu'il n'y a pas d'erreur
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Récupérer l'extension du fichier
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Vérification de l'extension (JPEG ou PNG uniquement)
        if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
            echo "Seules les images JPEG et PNG sont autorisées.";
            exit();
        }

        // Dossier de destination (chemin absolu pour éviter les erreurs)
        $imagePath = __DIR__ . "/image/jeux/";

        // Crée le dossier s'il n'existe pas
        if (!is_dir($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        // Vérifie si le dossier est accessible en écriture
        if (!is_writable($imagePath)) {
            echo "Erreur : le dossier de destination n'est pas accessible en écriture.<br>";
            echo "Chemin : $imagePath<br>";
            echo "Permissions actuelles : " . substr(sprintf('%o', fileperms($imagePath)), -4) . "<br>";
            exit();
        }

        // Nom du fichier image auquel on ajoute un id unique à la fin pour éviter les conflits
        $baseName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
        $baseName = preg_replace('/[^a-zA-Z0-9_\.]/', '_', $baseName);
        $imageName = $baseName . "_" . uniqid() . "." . $ext;

        // Déplacer l'image téléchargée dans le dossier approprié
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath . $imageName)) {
            echo "Erreur lors du téléchargement de l'image.<br>";
            echo "Chemin de destination : " . $imagePath . $imageName . "<br>";
            exit();
        }
    } else {
        // Si modification, garder l'image existante
        if ($id && !empty($jeu['image'])) {
            $imageName = $jeu['image'];
        } else {
            $imageName = "default.jpeg";
        }
    }

    if ($id) {
        // Mise à jour
        $sql = "UPDATE jeux SET nom = :nom, genre = :genre, type = :type, limite_age = :limite_age, image = :image WHERE id_jeux = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':genre' => $genre,
            ':type' => $type,
            ':limite_age' => $limite_age,
            ':image' => $imageName
        ]);
        // Redirection pour recharger la page avec la nouvelle image
        header("Location: page-modif-ajout-element.php?id=$id");
        exit();
    } else {
        // Ajout
        $sql = "INSERT INTO jeux (nom, genre, type, limite_age, image) VALUES (:nom, :genre, :type, :limite_age, :image)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':genre' => $genre,
            ':type' => $type,
            ':limite_age' => $limite_age,
            ':image' => $imageName
        ]);
        // Récupérer le nouvel id
        $newId = $conn->lastInsertId();
        header("Location: page-modif-ajout-element.php?id=$newId");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style/connexion-se-inscription.css" />
    <title><?= $id ? "Modifier le jeu" : "Ajouter un jeu" ?></title>
</head>
<body>

<h2 id="titre-formulaire"><?= $id ? "Modifier le jeu" : "Ajouter un jeu" ?></h2>

<a href="accueil.php" id="retour-accueil">⬅ Retour à l'accueil</a> |

<form method="POST" action="" enctype="multipart/form-data" id="form-jeu" class="form-jeu">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($jeu['id_jeux']) ?>" />
    <?php endif; ?>

    <label for="nom" class="label-nom">Nom :</label>
    <input type="text" id="nom" name="nom" class="input-nom" value="<?= htmlspecialchars($jeu['nom']) ?>" required /><br><br>

    <label for="genre" class="label-genre">Genre :</label>
    <input type="text" id="genre" name="genre" class="input-genre" value="<?= htmlspecialchars($jeu['genre']) ?>" required /><br><br>

    <label for="type" class="label-type">Type :</label>
    <input type="text" id="type" name="type" class="input-type" value="<?= htmlspecialchars($jeu['type']) ?>" required /><br><br>

    <label for="limite_age" class="label-limite-age">Âge limite :</label>
    <input type="number" id="limite_age" name="limite_age" class="input-limite-age" value="<?= htmlspecialchars($jeu['limite_age']) ?>" required /><br><br>

    <?php if ($id && !empty($jeu['image'])): ?>
        <p id="texte-image-actuelle">Image actuelle :</p>
        <img src="image/jeux/<?= htmlspecialchars($jeu['image']) ?>" alt="Image du jeu" width="150" id="image-actuelle" class="image-actuelle" /><br><br>
    <?php endif; ?>

    <label for="image" class="label-image">Image du jeu :</label>
    <input type="file" id="image" name="image" class="input-image" accept="image/jpeg, image/png" <?= $id ? '' : 'required' ?> /><br><br>

    <input type="submit" id="btn-submit-jeu" class="btn-submit-jeu" value="<?= $id ? "Mettre à jour" : "Ajouter" ?>" />
</form>

</body>
</html>
