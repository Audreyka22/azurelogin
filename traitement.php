<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "fatoudrey";

// Utilisation de gestion d'exceptions pour la connexion à la base de données
try {
    $conn = new mysqli($host, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        throw new Exception("Connexion échouée: " . $conn->connect_error);
    }

    // Récupération et nettoyage des données reçues via POST
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $date_naissance = $conn->real_escape_string($_POST['date_naissance']);
    $sexe = $conn->real_escape_string($_POST['sexe']);
    $programme = $conn->real_escape_string($_POST['programme']);

    // Préparation de la requête pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, date_naissance, sexe, programme) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $date_naissance, $sexe, $programme);

    // Exécution de la requête préparée
    if ($stmt->execute()) {
        echo "Inscription réussie";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Fermeture de la déclaration et de la connexion
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    die("Erreur: " . $e->getMessage());
}
?>
