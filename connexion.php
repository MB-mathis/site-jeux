<?php
session_start();
require_once "configbdd-pdo.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, user_name, password, role FROM users WHERE email = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($pass, $user['password'])) {
            $_SESSION["user_id"] = $user['id'];
            $_SESSION["user_name"] = $user['user_name'];
            // Vérification de la clé "role" avant utilisation
            $_SESSION["role"] = isset($user["role"]) ? $user["role"] : "user";  // Rôle par défaut 'user' si non défini

            if ($user["role"] == "admin") {
                header("Location: page-admin.php"); // Redirection vers l'interface d'admin
            } else {
                header("Location: accueil.php"); // Redirection utilisateur classique
            }
            exit();
        } else {
            $message = "Mot de passe ou email incorrect.";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style/connexion-se-inscription.css"> <!-- Assure-toi d'inclure le bon chemin du fichier CSS -->
</head>
<body>
    <div id="auth-form">
        
        <p id="form-message"><?php echo $message; ?></p>
        <form action="" method="post" id="registration-form">
             <h2 id="form-title">Se connecter</h2>
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-input" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-input" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Se connecter" class="form-btn">
            </div>
            <p id="login-link">Pas encore de compte ? <a href="inscription copy.php">S'inscrire</a></p>
        </form>
        
    </div>
</body>
</html>
