<?php
require_once "configbdd-pdo.php"; // Connexion à la base de données

// Vérifier si l'ID a été passé
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Préparer la requête SQL pour supprimer le jeu
    $sql = "DELETE FROM jeux WHERE id_jeux = :id";
    $stmt = $conn->prepare($sql);
    
    // Exécuter la requête avec l'ID du jeu
    $stmt->execute([':id' => $id]);
    
    // Redirection après suppression (facultative)
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'accueil.php';
    header("Location: $redirectUrl");
    exit();
} else {
    echo "Aucun ID de jeu fourni.";
    exit();
}
?>
