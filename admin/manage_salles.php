<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../connexion.php"); // Redirection si non connecté ou non admin
    exit();
}

// Récupérer toutes les salles de la base de données
$sql = "SELECT * FROM salles";
$stmt = $conn->prepare($sql);
$stmt->execute();
$salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Salles</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Gestion des Salles</h1>

    <div class="text-right mb-3">
        <a href="add_salle.php" class="btn btn-dark">Ajouter une Salle</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Ville</th>
                <th>Capacité</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salles as $salle): ?>
                <tr>
                    <td><?php echo $salle['id_salle']; ?></td>
                    <td><?php echo htmlspecialchars($salle['titre']); ?></td>
                    <td><?php echo htmlspecialchars($salle['ville']); ?></td>
                    <td><?php echo $salle['capacite']; ?></td>
                    <td><?php echo $salle['prix']; ?> €</td>
                    <td>
                        <a href="edit_salle.php?id=<?php echo $salle['id_salle']; ?>" class="btn btn-dark btn-sm">Modifier</a>
                        <a href="delete_salle.php?id=<?php echo $salle['id_salle']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?');">Supprimer</a>
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
