<?php
session_start();
require_once "configbdd-pdo.php";

if (!isset($_GET['id'])) {
    echo "Aucun jeu spécifié.";
    exit;
}

$id = (int) $_GET['id'];

// Récupération du jeu
$stmt = $conn->prepare("SELECT * FROM jeux WHERE id_jeux = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$jeu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$jeu) {
    echo "Jeu introuvable.";
    exit;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du jeu</title>
    <style>
        .jeu-details {
            max-width: 600px;
            margin: 40px auto;
            text-align: center;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .jeu-details img {
            max-width: 100%;
            border-radius: 8px;
        }
        .jeu-details h2 {
            margin-top: 20px;
        }
        .jeu-details p {
            font-size: 18px;
            margin: 10px 0;
        }
        .actions {
            margin-top: 20px;
        }
        .actions form {
            display: inline-block;
            margin: 0 10px;
        }
        .actions input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
        }
        .modifier {
            background-color: #2196F3;
            color: white;
        }
        .supprimer {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>

<div class="jeu-details" id="jeu-details">
    <?php
         $imageName = !empty($jeu['image']) ? $jeu['image'] : "default.jpeg";
         $imagePath = "image/jeux/" . $imageName;
        if (!file_exists($imagePath)) {
            $imagePath = "image/jeux/default.jpeg";
        }
    ?>
    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($jeu['nom']) ?>" class="jeu-image" id="jeu-image">
    <h2 class="jeu-nom" id="jeu-nom"><?= htmlspecialchars($jeu['nom']) ?></h2>
    <p class="jeu-genre" id="jeu-genre"><strong>Genre :</strong> <?= htmlspecialchars($jeu['genre']) ?></p>
    <p class="jeu-type" id="jeu-type"><strong>Type :</strong> <?= htmlspecialchars($jeu['type']) ?></p>
    <p class="jeu-limite-age" id="jeu-limite-age"><strong>Limite d'âge :</strong> <?= htmlspecialchars($jeu['limite_age']) ?></p>

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="actions" id="jeu-actions">
        <!-- Bouton modifier -->
        <form method="POST" action="page-modif-ajout-element.php" class="form-modifier" id="form-modifier">
            <input type="hidden" name="id" value="<?= $jeu['id_jeux'] ?>">
            <input type="submit" value="Modifier" class="modifier" id="btn-modifier">
        </form>

        <!-- Bouton supprimer -->
        <form method="POST" action="page-supprime-element.php" class="form-supprimer" id="form-supprimer" onsubmit="return confirm('Supprimer ce jeu ?');">
            <input type="hidden" name="id" value="<?= $jeu['id_jeux'] ?>">
            <input type="submit" value="Supprimer" class="supprimer" id="btn-supprimer">
        </form>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
