<?php 
// Inclure la connexion à la base de données et le header
include 'includes/db.php';
include 'includes/header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Récupérer l'ID de l'utilisateur à partir de la session
$user_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur connecté
$sql = "SELECT * FROM utilisateurs WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    echo "Erreur : utilisateur non trouvé.";
    exit();
}

// Requête pour récupérer les réservations futures
$query_futures = "SELECT * FROM reservations 
                  INNER JOIN salles ON reservations.id_salle = salles.id_salle 
                  WHERE id_utilisateur = :user_id 
                  AND date_debut >= CURDATE()";
$stmt_futures = $conn->prepare($query_futures);
$stmt_futures->bindParam(':user_id', $user_id);
$stmt_futures->execute();
$reservations_futures = $stmt_futures->fetchAll(PDO::FETCH_ASSOC);

// Requête pour récupérer les réservations passées
$query_passees = "SELECT * FROM reservations 
                  INNER JOIN salles ON reservations.id_salle = salles.id_salle 
                  WHERE id_utilisateur = :user_id 
                  AND date_fin < CURDATE()";
$stmt_passees = $conn->prepare($query_passees);
$stmt_passees->bindParam(':user_id', $user_id);
$stmt_passees->execute();
$reservations_passees = $stmt_passees->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Assurez-vous que le chemin vers votre fichier CSS est correct -->
    <style>
        .reservation-card {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .reservation-header {
            font-weight: bold;
            font-size: 1.2em;
        }
        .btn-noter {
            background-color: transparent;
            color: black;
            border: 1px solid black;
            transition: all 0.3s ease;
        }

        .btn-noter:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Bienvenue sur votre profil, <?php echo htmlspecialchars($user['pseudo']); ?>!</h1>
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Vos informations</h4>
            <p><strong>Pseudo : </strong><?php echo htmlspecialchars($user['pseudo']); ?></p>
            <p><strong>Nom : </strong><?php echo htmlspecialchars($user['nom']); ?></p>
            <p><strong>Prénom : </strong><?php echo htmlspecialchars($user['prenom']); ?></p>
            <p><strong>Email : </strong><?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Genre : </strong><?php echo htmlspecialchars($user['genre']); ?></p>
            <p><strong>Date d'inscription : </strong><?php echo htmlspecialchars($user['date_inscription']); ?></p>
        </div>
    </div>

    <h2 class="mt-5">Réservations futures</h2>
    <?php if (count($reservations_futures) > 0): ?>
        <?php foreach ($reservations_futures as $reservation): ?>
            <div class="reservation-card">
                <div class="reservation-header"><?php echo $reservation['titre']; ?></div>
                <p>Date d'arrivée : <?php echo $reservation['date_debut']; ?></p>
                <p>Date de départ : <?php echo $reservation['date_fin']; ?></p>
                <p>Prix total : <?php echo $reservation['prix_total']; ?> €</p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune réservation future.</p>
    <?php endif; ?>

    <h2 class="mt-5">Réservations passées</h2>
    <?php if (count($reservations_passees) > 0): ?>
        <?php foreach ($reservations_passees as $reservation): ?>
            <div class="reservation-card">
                <div class="reservation-header"><?php echo $reservation['titre']; ?></div>
                <p>Date d'arrivée : <?php echo $reservation['date_debut']; ?></p>
                <p>Date de départ : <?php echo $reservation['date_fin']; ?></p>
                <p>Prix total : <?php echo $reservation['prix_total']; ?> €</p>
                <a href="submit_avis.php?id=<?php echo $reservation['id_salle']; ?>" class="btn btn-noter">Noter cette salle</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune réservation passée.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>

