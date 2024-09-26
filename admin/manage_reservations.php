<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../connexion.php"); // Redirection si non connecté ou non admin
    exit();
}

// Récupérer toutes les réservations
$sql = "SELECT r.id_reservation, r.date_debut, r.date_fin, r.prix_total, r.statut, s.titre AS salle, u.pseudo AS utilisateur 
        FROM reservations r 
        JOIN salles s ON r.id_salle = s.id_salle 
        JOIN utilisateurs u ON r.id_utilisateur = u.id 
        ORDER BY r.date_debut DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Réservations</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn {
            padding: 10px 20px;
        }
        table {
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Gestion des Réservations</h1>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID Réservation</th>
                <th>Utilisateur</th>
                <th>Salle</th>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Prix Total</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['id_reservation']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['utilisateur']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['salle']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['date_debut']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['date_fin']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['prix_total']); ?> €</td>
                    <td><?php echo htmlspecialchars($reservation['statut']); ?></td>
                    <td>
                        <a href="edit_reservation.php?id=<?php echo $reservation['id_reservation']; ?>" class="btn btn-dark btn-sm">Modifier</a>
                        <a href="delete_reservation.php?id=<?php echo $reservation['id_reservation']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
