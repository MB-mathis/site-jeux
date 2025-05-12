<?php
$server_name = "db";
$user_name = "root";
$password = "root";
$db_name = "user_form";

try {
    $conn = new PDO("mysql:host=$server_name;dbname=$db_name", $user_name, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("La connexion a échoué: " . $e->getMessage());
}
?>
