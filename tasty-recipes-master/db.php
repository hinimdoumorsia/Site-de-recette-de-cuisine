<?php 
// Remplacez par les informations spécifiques à InfinityFree
$host = "sql212.infinityfree.com";  // Hôte correct
$username = "if0_38028754";  // Nom d'utilisateur MySQL
$password = "4Y0kgDEnoH";  // Mot de passe MySQL
$dbname = "if0_38028754_database";  // Nom de votre base de données

try {
    // Connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // En cas d'erreur, enregistrez l'erreur dans un fichier de log
    error_log("Erreur de connexion : " . $e->getMessage(), 3, "errors.log");
    echo "Erreur de connexion à la base de données. Veuillez réessayer plus tard.";
    exit();  // Arrête l'exécution en cas d'erreur
}
?>
