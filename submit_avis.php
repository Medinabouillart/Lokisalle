<?php
include 'includes/db.php';
session_start();

if (isset($_POST['id_salle'], $_POST['note'], $_POST['commentaire'], $_SESSION['user_id'])) {
    $id_salle = $_POST['id_salle'];
    $note = $_POST['note'];
    $commentaire = $_POST['commentaire'];
    $id_utilisateur = $_SESSION['user_id'];

    // Insertion de l'avis dans la base de données
    $query = "INSERT INTO avis (id_salle, id_utilisateur, note, commentaire, date_avis) 
              VALUES (:id_salle, :id_utilisateur, :note, :commentaire, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_salle', $id_salle);
    $stmt->bindParam(':id_utilisateur', $id_utilisateur);
    $stmt->bindParam(':note', $note);
    $stmt->bindParam(':commentaire', $commentaire);
    
    if ($stmt->execute()) {
        // Redirection après la soumission de l'avis
        header('Location: details_salle.php?id=' . $id_salle);
        exit;
    } else {
        echo "Erreur lors de l'enregistrement de l'avis.";
    }
} else {
    echo "Données manquantes.";
}
?>
