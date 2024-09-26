<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../connexion.php"); // Redirection si non connecté ou non admin
    exit();
}

// Requêtes pour récupérer le Top 5
// Top 5 des salles les mieux notées
$top_salles_notees_sql = "SELECT s.titre, AVG(a.note) AS moyenne_note 
                          FROM salles s 
                          JOIN avis a ON s.id_salle = a.id_salle 
                          GROUP BY s.id_salle 
                          ORDER BY moyenne_note DESC 
                          LIMIT 5";
$top_salles_notees_stmt = $conn->prepare($top_salles_notees_sql);
$top_salles_notees_stmt->execute();
$top_salles_notees = $top_salles_notees_stmt->fetchAll(PDO::FETCH_ASSOC);

// Top 5 des salles les plus réservées
$top_salles_reservees_sql = "SELECT s.titre, COUNT(r.id_salle) AS total_reservations 
                             FROM salles s 
                             JOIN reservations r ON s.id_salle = r.id_salle 
                             GROUP BY s.id_salle 
                             ORDER BY total_reservations DESC 
                             LIMIT 5";
$top_salles_reservees_stmt = $conn->prepare($top_salles_reservees_sql);
$top_salles_reservees_stmt->execute();
$top_salles_reservees = $top_salles_reservees_stmt->fetchAll(PDO::FETCH_ASSOC);

// Top 5 des membres par nombre de réservations
$top_membres_quantite_sql = "SELECT u.pseudo, COUNT(r.id_utilisateur) AS total_reservations 
                             FROM utilisateurs u 
                             JOIN reservations r ON u.id = r.id_utilisateur 
                             GROUP BY u.id 
                             ORDER BY total_reservations DESC 
                             LIMIT 5";
$top_membres_quantite_stmt = $conn->prepare($top_membres_quantite_sql);
$top_membres_quantite_stmt->execute();
$top_membres_quantite = $top_membres_quantite_stmt->fetchAll(PDO::FETCH_ASSOC);

// Top 5 des membres par montant dépensé
$top_membres_prix_sql = "SELECT u.pseudo, SUM(r.prix_total) AS total_depense 
                         FROM utilisateurs u 
                         JOIN reservations r ON u.id = r.id_utilisateur 
                         GROUP BY u.id 
                         ORDER BY total_depense DESC 
                         LIMIT 5";
$top_membres_prix_stmt = $conn->prepare($top_membres_prix_sql);
$top_membres_prix_stmt->execute();
$top_membres_prix = $top_membres_prix_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ton propre fichier CSS -->
    <link rel="stylesheet" href="/lokisalle/css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Tableau de bord Admin</h1>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestion des Salles</h5>
                    <p class="card-text">Ajouter, modifier ou supprimer des salles.</p>
                    <a href="manage_salles.php" class="btn btn-dark">Gérer les salles</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestion des Réservations</h5>
                    <p class="card-text">Consulter les réservations des utilisateurs.</p>
                    <a href="manage_reservations.php" class="btn btn-dark">Gérer les réservations</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestion des Avis</h5>
                    <p class="card-text">Voir et modérer les avis des utilisateurs.</p>
                    <a href="manage_avis.php" class="btn btn-dark">Gérer les avis</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section pour afficher les Top 5 -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Top 5 des Salles les Mieux Notées</h3>
            <ul class="list-group">
                <?php foreach ($top_salles_notees as $salle): ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($salle['titre']); ?> - Note Moyenne: <?php echo number_format($salle['moyenne_note'], 2); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-6">
            <h3>Top 5 des Salles les Plus Réservées</h3>
            <ul class="list-group">
                <?php foreach ($top_salles_reservees as $salle): ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($salle['titre']); ?> - Réservations: <?php echo $salle['total_reservations']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Top 5 des Membres par Quantité de Réservations</h3>
            <ul class="list-group">
                <?php foreach ($top_membres_quantite as $membre): ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($membre['pseudo']); ?> - Réservations: <?php echo $membre['total_reservations']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-6">
            <h3>Top 5 des Membres par Montant Dépensé</h3>
            <ul class="list-group">
                <?php foreach ($top_membres_prix as $membre): ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($membre['pseudo']); ?> - Dépenses: <?php echo number_format($membre['total_depense'], 2); ?> €
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>


