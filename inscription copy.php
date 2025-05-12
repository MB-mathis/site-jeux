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
        $message = "erreur lors de la creation de compte ";
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
</head>
<body>
    <h2>Créer un compte</h2>
    <p><?php echo $message; ?></p>
    <form action="" method="post">
        <input type="text" name="user_name" placeholder="Nom d'utilisateur" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <input type="submit" value="S'inscrire">
    </form>
    <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
</body>
</html>
