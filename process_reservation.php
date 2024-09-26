<?php
include 'includes/db.php'; // Connexion à la base de données
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

// Vérifier que les données du formulaire ont été soumises
if (isset($_POST['id_salle'], $_POST['date_arrivee'], $_POST['date_depart'])) {
    $id_salle = $_POST['id_salle'];
    $date_arrivee = $_POST['date_arrivee'];
    $date_depart = $_POST['date_depart'];
    $user_id = $_SESSION['user_id']; // L'ID de l'utilisateur connecté

    // Vérifier que la date de début est égale ou supérieure à aujourd'hui
    $aujourdhui = date('Y-m-d');
    if ($date_arrivee < $aujourdhui) {
        echo "Erreur : Vous ne pouvez pas réserver à une date antérieure à aujourd'hui.";
        exit;
    }

    // Calculer le nombre de jours de réservation
    $date1 = new DateTime($date_arrivee);
    $date2 = new DateTime($date_depart);
    $interval = $date1->diff($date2);
    $jours = $interval->days;

    if ($jours <= 0) {
        echo "Erreur : La date de départ doit être supérieure à la date d'arrivée.";
        exit;
    }

    // Vérifier si la salle est déjà réservée pour les dates choisies
    $query = "SELECT COUNT(*) FROM reservations 
              WHERE id_salle = :id_salle 
              AND (date_debut <= :date_depart AND date_fin >= :date_arrivee)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_salle', $id_salle);
    $stmt->bindParam(':date_arrivee', $date_arrivee);
    $stmt->bindParam(':date_depart', $date_depart);
    $stmt->execute();
    $reservation_existante = $stmt->fetchColumn();

    if ($reservation_existante > 0) {
        echo "Erreur : Cette salle est déjà réservée pour les dates sélectionnées.";
        exit;
    }

    // Récupérer les informations de la salle (prix)
    $query = "SELECT prix FROM salles WHERE id_salle = :id_salle";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_salle', $id_salle);
    $stmt->execute();
    $salle = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($salle) {
        // Calculer le prix total avec la TVA (20%)
        $prix_total = $salle['prix'] * $jours;
        $tva = $prix_total * 0.20;
        $prix_avec_tva = $prix_total + $tva;

        // Insérer la réservation dans la base de données avec le statut "confirmée"
        $query = "INSERT INTO reservations (id_salle, id_utilisateur, date_debut, date_fin, prix_total, statut)
                  VALUES (:id_salle, :id_utilisateur, :date_arrivee, :date_depart, :prix_avec_tva, 'confirmée')";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_salle', $id_salle);
        $stmt->bindParam(':id_utilisateur', $user_id);
        $stmt->bindParam(':date_arrivee', $date_arrivee);
        $stmt->bindParam(':date_depart', $date_depart);
        $stmt->bindParam(':prix_avec_tva', $prix_avec_tva);

        if ($stmt->execute()) {
            // Rediriger l'utilisateur vers une page de confirmation ou le profil
            header('Location: confirmation_reservation.php');
            exit;
        } else {
            echo "Erreur lors de l'enregistrement de la réservation.";
        }
    } else {
        echo "Salle non trouvée.";
    }
} else {
    echo "Données manquantes pour la réservation.";
}
?>



