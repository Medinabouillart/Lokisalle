<?php
// Connexion à la base de données
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);  // Hasher le mot de passe
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $genre = $_POST['genre'];

    // Insérer les données dans la table utilisateurs
    $sql = "INSERT INTO utilisateurs (pseudo, mot_de_passe, nom, prenom, email, genre) VALUES (:pseudo, :mot_de_passe, :nom, :prenom, :email, :genre)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':genre', $genre);

    if ($stmt->execute()) {
        // Rediriger l'utilisateur après une inscription réussie
        header("Location: ../index.php");
        exit();
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>
