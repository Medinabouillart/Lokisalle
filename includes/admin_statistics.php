<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../connexion.php"); // Redirection si non connecté ou non admin
    exit();
}

include 'top_5_queries.php'; // Le fichier où tu as mis tes requêtes Top 5

include '../includes/header.php'; // Header
?>

<div class="container mt-5">
    <h1 class="text-center">Statistiques Admin</h1>

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
