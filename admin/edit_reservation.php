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

    // Récupérer les détails de la réservation
    $sql = "SELECT * FROM reservations WHERE id_reservation = :id_reservation";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_reservation', $id_reservation);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier que la réservation existe
    if (!$reservation) {
        echo "Réservation non trouvée.";
        exit();
    }

    // Mettre à jour la réservation après soumission du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $prix_total = $_POST['prix_total'];
        $statut = $_POST['statut'];

        // Requête de mise à jour
        $sql_update = "UPDATE reservations 
                       SET date_debut = :date_debut, date_fin = :date_fin, prix_total = :prix_total, statut = :statut
                       WHERE id_reservation = :id_reservation";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':date_debut', $date_debut);
        $stmt_update->bindParam(':date_fin', $date_fin);
        $stmt_update->bindParam(':prix_total', $prix_total);
        $stmt_update->bindParam(':statut', $statut);
        $stmt_update->bindParam(':id_reservation', $id_reservation);

        if ($stmt_update->execute()) {
            header("Location: manage_reservations.php"); // Redirection après mise à jour
            exit();
        } else {
            echo "Erreur lors de la mise à jour.";
        }
    }
} else {
    echo "ID de réservation manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Réservation</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn {
            padding: 10px 20px;
        }
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h1 class="text-center">Modifier Réservation</h1>
    <form method="POST">
        <div class="form-group">
            <label for="date_debut">Date de début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut" value="<?php echo htmlspecialchars($reservation['date_debut']); ?>" required>
        </div>
        <div class="form-group">
            <label for="date_fin">Date de fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin" value="<?php echo htmlspecialchars($reservation['date_fin']); ?>" required>
        </div>
        <div class="form-group">
            <label for="prix_total">Prix total (€)</label>
            <input type="number" class="form-control" id="prix_total" name="prix_total" value="<?php echo htmlspecialchars($reservation['prix_total']); ?>" required>
        </div>
        <div class="form-group">
            <label for="statut">Statut</label>
            <select class="form-control" id="statut" name="statut">
                <option value="confirmée" <?php if ($reservation['statut'] == 'confirmée') echo 'selected'; ?>>Confirmée</option>
                <option value="en attente" <?php if ($reservation['statut'] == 'en attente') echo 'selected'; ?>>En attente</option>
                <option value="annulée" <?php if ($reservation['statut'] == 'annulée') echo 'selected'; ?>>Annulée</option>
            </select>
        </div>
        <button type="submit" class="btn btn-dark">Mettre à jour</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
