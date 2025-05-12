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
            $message = "mot de passe ou email incorrect ";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Se connecter</h2>
    <p><?php echo $message; ?></p>
    <form action="" method="post">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <input type="submit" value="Se connecter">
    </form>
    <p>Pas encore de compte ? <a href="inscription copy.php">S'inscrire</a></p>
</body>
</html>
