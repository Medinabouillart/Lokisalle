<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../connexion.php"); // Redirection si non connecté ou non admin
    exit();
}

// Vérifier que l'ID de la réservation est passé dans l'URL
if (isset($_GET['id'])) {
    $id_reservation = $_GET['id'];

    // Requête pour supprimer la réservation
    $sql = "DELETE FROM reservations WHERE id_reservation = :id_reservation";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_reservation', $id_reservation);

    if ($stmt->execute()) {
        // Redirection après suppression réussie
        header("Location: manage_reservations.php?message=deleted"); // Rediriger vers la gestion des réservations avec un message de confirmation
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "ID de réservation manquant.";
}
?>
