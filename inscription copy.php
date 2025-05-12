<?php
require_once "configbdd-pdo.php"; // Inclusion de la connexion à la base de données

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user_name'];
    $pass = $_POST['password'];
    $email = $_POST['email'];

    // Vérifier si l'email existe déjà
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $check_email->bindParam(":email", $email, PDO::PARAM_STR);
    $check_email->execute();

    if ($check_email->rowCount() > 0) {
        $message = "Erreur lors de la création de compte.";
    } else {
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $role = ($email === "mathis@gmail.com") ? "admin" : "user"; // Remplace par l'email de ton admin
        $sql = "INSERT INTO users (user_name, password, email, role) VALUES (:user_name, :password, :email, :role)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":user_name", $user, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashed_pass, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":role", $role, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $message = "Compte créé avec succès !";
                header("Location: connexion.php?success=1");
                exit();
            } else {
                $message = "Erreur lors de la création du compte.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style/connexion-se-inscription.css"> <!-- Assure-toi de lier le bon fichier CSS -->
</head>
<body>
    <div id="registration-form">
        <h2 id="form-title">Créer un compte</h2>
        <p id="form-message"><?php echo $message; ?></p>
        
        <form action="" method="post" id="auth-form">
            <div class="form-group">
                <label for="user_name">Nom d'utilisateur :</label>
                <input type="text" name="user_name" id="user_name" placeholder="Nom d'utilisateur" required class="form-input"><br><br>
            </div>
            
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" placeholder="Email" required class="form-input"><br><br>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required class="form-input"><br><br>
            </div>
            
            <div class="form-group">
                <input type="submit" value="S'inscrire" id="submit-btn" class="form-btn">
            </div>
        </form>
        
        <p id="login-link">Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
    </div>
</body>
</html>
