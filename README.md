# site-jeux
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
│ └── default.jpg

pgsql
Copier
Modifier

---

## ⚙️ Configuration

### Prérequis :
- PHP ≥ 7.4
- Serveur MySQL
- Serveur local (XAMPP, WAMP, MAMP, etc.)

### 1. Base de données

Créer une base de données `jeux_db` (par exemple), puis exécuter ce script SQL :

```sql
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
2. Connexion à la base (configbdd-pdo.php)
Adapte ce fichier avec tes identifiants MySQL :

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
Le style est centralisé dans :

bash
Copier
Modifier
style/connexion-se-inscription.css
Tous les formulaires utilisent les classes .form-wrapper, .input-field, .submit-btn, etc.

Le fond d'écran est une image (images/jeux/default.jpg) qui prend toute la page, fixée en arrière-plan.

👤 Rôles
admin : accès aux pages de gestion

user : accès limité à la page d'accueil

L’email mathis@gmail.com est automatiquement associé au rôle admin.

🧪 Test
Tu peux tester :

L’inscription : inscription.php

La connexion : connexion.php

L’ajout ou modification : ajout-modif.php

L’accueil : accueil.php

✨ Auteur
Projet réalisé par Mathis Maëlane Bongo — BTS SIO 1ère année
Limoges, France 🇫🇷

📜 Licence
Ce projet est open-source. Utilisation libre à des fins pédagogiques.
