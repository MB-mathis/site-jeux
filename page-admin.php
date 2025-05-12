<?php
session_start();
require_once "configbdd-pdo.php"; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté et s'il est admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: connexion.php"); // Redirige vers la connexion si pas admin
    exit();
}

// Récupérer tous les utilisateurs
$sql1 = "SELECT user_name, email FROM users";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$users = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les jeux
$sql2 = "SELECT id_jeux, nom, genre, limite_age, type FROM jeux";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$jeux = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Liste des elements</title>
    <link rel="stylesheet" href="style/admin.css">

</head>
<body>
    <a href="page-modif-ajout-element.php" class="btn">ajouter un jeu </a><br>
    <br>
    <a href="accueil.php" class="btn">accueil</a>
    <p><a href="deconnexion.php">Se déconnecter</a></p>
    <h2>Liste des utilisateurs</h2>
    <table border="1">
        <tr>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['user_name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    


    <h2>Liste des jeux</h2>
    <table border="1">
        <tr>
            <th>Nom du jeux</th>
            <th>genre</th>
            <th>limte age</th>
            <th>type</th>

        </tr>
        <?php foreach ($jeux as $jeu): ?>
            <tr>
                <td><?= htmlspecialchars($jeu['nom']) ?></td>
                <td><?= htmlspecialchars($jeu['genre']) ?></td>
                <td><?= htmlspecialchars($jeu['limite_age']) ?></td>
                <td><?= htmlspecialchars($jeu['type']) ?></td>
                <td>
                <!-- Formulaire pour modifier le jeu -->
                <form method="POST" action="page-modif-ajout-element.php">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($jeu['id_jeux']) ?>">
                    <input type="submit" value="Modifier">
                </form>
                <!-- Formulaire pour supprimer le jeu -->
                <form method="POST" action="page-supprime-element.php">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($jeu['id_jeux']) ?>">
                    <input type="submit" value="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce jeu ?');">    
                </form>
            </td>

            </tr>
        <?php endforeach; ?>
    </table>
    

</body>
</html>
