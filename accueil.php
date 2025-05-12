<?php
session_start(); // Démarrer la session
require_once "configbdd-pdo.php"; // Connexion à la base de données

// Définir le nombre d'éléments par page
$itemsParPage = 3; // Afficher LE NOMBRE DE jeux par page

// Déterminer la page actuelle
if (isset($_GET['page'])) {
    $pageActuelle = (int) $_GET['page']; // On récupère la valeur de l'URL
} else {
    $pageActuelle = 1; // Page par défaut si aucun paramètre
}
$pageActuelle = max($pageActuelle, 1); // Assurer qu'on est au minimum à la page 1

// Calcul de l'offset pour MySQL
$offset = ($pageActuelle - 1) * $itemsParPage;

// Récupérer tous les jeux
$sql = "SELECT `id_jeux`, nom, genre, type, limite_age FROM jeux LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $itemsParPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$jeux = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcul du nombre total de pages
$totalJeux = $conn->query("SELECT COUNT(*) FROM jeux")->fetchColumn();
$totalPages = ceil($totalJeux / $itemsParPage);

// Vérifier si des jeux existent
if (empty($jeux)) {
    echo "Aucun jeu trouvé.";
}
// Vérifier si l'utilisateur est un administrateur (exemple : session['role'] = 'admin')
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">

    <title>Liste des jeux</title>
</head>
<body>
    <header id="page-header">
        <h2 id="page-title">Liste des jeux</h2>

        <?php if (isset($_SESSION['user_id'])): ?>
            <p id="user-welcome">Bienvenue, <?= htmlspecialchars($_SESSION['user_name']) ?> !</p>
            <a href="deconnexion.php" id="logout-link">Se déconnecter</a>

            <!-- Lien vers la page admin (visible uniquement pour un administrateur) -->
            <?php if ($isAdmin): ?>
                | <a href="page-admin.php" id="admin-link">Page Admin</a>
            <?php endif; ?>

        <?php else: ?>
            <a href="connexion.php" id="login-link">Se connecter</a>
        <?php endif; ?>

        <!-- Bouton pour ajouter un nouveau jeu -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="page-modif-ajout-element.php" id="add-game-form">
                <input type="submit" value="Ajouter un jeu" id="add-game-button">
            </form>
        <?php endif; ?>
    </header>

    <section id="games-list">
        <div class="jeux-container">
            <?php foreach ($jeux as $jeu): ?>
                <div class="jeu">
                    <?php
                        // Vérifie dans le système de fichiers
                        $imageFilePath = "image/jeux/" . $jeu['id_jeux'] . ".jpeg";
                        if (!file_exists($imageFilePath)) {
                            $imageSrc = "image/jeux/default.jpeg"; // pour HTML
                        } else {
                            $imageSrc = $imageFilePath; // chemin pour HTML aussi
                        }
                    ?>
                    <a href="details-jeu.php?id=<?= $jeu['id_jeux'] ?>" class="jeu-link">
                        <img src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($jeu['nom']) ?>" class="jeu-image">
                        <div class="jeu-info">
                            <h3 class="jeu-name"><?= htmlspecialchars($jeu['nom']) ?></h3>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($totalPages > 1): ?>

            <!-- Première -->
            <a href="?page=1" class="pagination-link <?= ($pageActuelle == 1) ? 'active' : '' ?>">Première</a>

            <!-- Précédente -->
            <a href="?page=<?= max(1, $pageActuelle - 1) ?>" class="pagination-link <?= ($pageActuelle == 1) ? 'disabled' : '' ?>">Précédente</a>

            <?php
            $pagesDebut = 4;
            $pagesAutour = 1;
            $pagesFin = 3;

            $affiche = [];

            // Pages 1 à 4
            for ($i = 1; $i <= min($pagesDebut, $totalPages); $i++) {
                $affiche[] = $i;
            }

            // 3 pages autour de la page actuelle
            for ($i = $pageActuelle - $pagesAutour; $i <= $pageActuelle + $pagesAutour; $i++) {
                if ($i > 0 && $i <= $totalPages) {
                    $affiche[] = $i;
                }
            }

            // Dernières pages (3 dernières)
            for ($i = max($totalPages - $pagesFin + 1, 1); $i <= $totalPages; $i++) {
                $affiche[] = $i;
            }

            // Supprimer doublons et trier
            $affiche = array_unique($affiche);
            sort($affiche);

            // Affichage des pages avec "..."
            $prev = 0;
            foreach ($affiche as $i) {
                if ($prev && $i > $prev + 1) {
                    echo '<span>...</span>';
                }

                if ($i == $pageActuelle) {
                    echo "<strong>$i</strong>";
                } else {
                    echo "<a href='?page=$i' class='pagination-link'>$i</a>";
                }

                $prev = $i;
            }
            ?>

            <!-- Suivante -->
            <a href="?page=<?= min($totalPages, $pageActuelle + 1) ?>" class="pagination-link <?= ($pageActuelle == $totalPages) ? 'disabled' : '' ?>">Suivante</a>

            <!-- Dernière -->
            <a href="?page=<?= $totalPages ?>" class="pagination-link <?= ($pageActuelle == $totalPages) ? 'active' : '' ?>">Dernière</a>

        <?php endif; ?>
    </div>
</body>
</html>
