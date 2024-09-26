<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../connexion.php"); // Redirection si non connecté ou non admin
    exit();
}

// Vérifier que l'ID de la salle est passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: manage_salles.php");
    exit();
}

$id_salle = $_GET['id'];

// Récupérer les informations de la salle pour confirmation avant suppression
$sql = "SELECT * FROM salles WHERE id_salle = :id_salle";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_salle', $id_salle);
$stmt->execute();
$salle = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$salle) {
    echo "Salle non trouvée.";
    exit();
}

// Suppression de la salle si la requête est confirmée
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql_delete = "DELETE FROM salles WHERE id_salle = :id_salle";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(':id_salle', $id_salle);

    if ($stmt_delete->execute()) {
        header("Location: manage_salles.php?delete_success=1");
        exit();
    } else {
        echo "Erreur lors de la suppression de la salle.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une Salle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Supprimer la Salle</h1>
    
    <div class="alert alert-danger">
        <p>Êtes-vous sûr de vouloir supprimer la salle suivante ?</p>
        <ul>
            <li><strong>Titre :</strong> <?php echo htmlspecialchars($salle['titre']); ?></li>
            <li><strong>Ville :</strong> <?php echo htmlspecialchars($salle['ville']); ?></li>
            <li><strong>Capacité :</strong> <?php echo htmlspecialchars($salle['capacite']); ?> personnes</li>
            <li><strong>Prix :</strong> <?php echo htmlspecialchars($salle['prix']); ?> €</li>
            <li><strong>Description :</strong> <?php echo htmlspecialchars($salle['description']); ?></li>
        </ul>
        <p>Cette action est irréversible.</p>
    </div>

    <form method="POST">
        <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
        <a href="manage_salles.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
