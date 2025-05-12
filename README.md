# 🎮 Projet PHP - Gestion de Jeux

Ce projet est une application web développée en **PHP** avec une base de données **MySQL**. Elle permet à des utilisateurs de s'inscrire, se connecter, et gérer une collection de jeux vidéo (ajout, modification, affichage).

---

## 🚀 Fonctionnalités

- ✅ Inscription d’un utilisateur
- ✅ Connexion sécurisée avec hash de mot de passe (`password_hash`)
- ✅ Rôle `admin` ou `user` attribué automatiquement
- ✅ Ajout et modification de jeux avec upload d’image
- ✅ Page d’accueil avec fond personnalisé
- ✅ Design moderne avec effets CSS (fond transparent, survol lumineux)

---

## 📁 Structure du projet

/ (racine)
├── accueil.php
├── inscription.php
├── connexion.php
├── ajout-modif.php
├── configbdd-pdo.php
├── style/
│ └── connexion-se-inscription.css
├── images/
│ └── jeux/
│ ├── 1.jpg
│ ├── 2.jpg
│ └── default.jpg

yaml
Copier
Modifier

---

## ⚙️ Configuration

### Prérequis :
- PHP ≥ 7.4
- Serveur MySQL
- Serveur local (XAMPP, WAMP, MAMP, etc.)

---

## 📥 Installation via Git

1. Ouvre un terminal (ou Git Bash sous Windows)
2. Va dans le dossier de ton serveur local (`htdocs` sous XAMPP par exemple)
3. Clone le projet avec la commande suivante :

```bash
git clone https://github.com/votre-utilisateur/votre-repo.git
Remplace votre-utilisateur et votre-repo par les bons noms GitHub.

Renomme le dossier si nécessaire

Lance ton serveur Apache/MySQL

Accède au projet dans ton navigateur :
http://localhost/nom-du-projet/

📦 Base de données
Créer une base jeux_db, puis exécuter le script SQL :

sql
Copier
Modifier
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(20)
);

CREATE TABLE jeux (
    id_jeux INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    genre VARCHAR(50),
    type VARCHAR(50),
    limite_age INT,
    image VARCHAR(255)
);
🔧 Connexion à la base (configbdd-pdo.php)
Configure ton fichier avec tes identifiants :

php
Copier
Modifier
<?php
$host = 'localhost';
$db = 'jeux_db';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
🎨 Style et UI
Le style se trouve dans :

bash
Copier
Modifier
style/connexion-se-inscription.css
Champs transparents

Effet de lumière verte au survol

Fond fixe couvrant toute la page (images/jeux/default.jpg)

👤 Rôles
admin : accès total (mathis@gmail.com)

user : accès classique

✨ Auteur
Projet réalisé par Mathis Maëlane Bongo — BTS SIO 1ère année
Limoges, France 🇫🇷

📜 Licence
Projet libre de droits pour un usage pédagogique.
