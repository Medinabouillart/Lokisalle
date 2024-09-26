<?php
include '../includes/db.php'; // Connexion à la base de données

// Récupérer tous les avis
$sql = "SELECT a.id_avis, a.commentaire, a.note, u.pseudo, s.titre, a.date_enregistrement 
        FROM avis a 
        JOIN utilisateurs u ON a.id_membre = u.id 
        JOIN salles s ON a.id_salle = s.id_salle";
$stmt = $conn->prepare($sql);
$stmt->execute();
$avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Avis</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Gestion des Avis</h1>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID Avis</th>
                <th>Membre</th>
                <th>Salle</th>
                <th>Commentaire</th>
                <th>Note</th>
                <th>Date Enregistrement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($avis as $avis_item): ?>
                <tr>
                    <td><?php echo $avis_item['id_avis']; ?></td>
                    <td><?php echo $avis_item['pseudo']; ?></td>
                    <td><?php echo $avis_item['titre']; ?></td>
                    <td><?php echo $avis_item['commentaire']; ?></td>
                    <td><?php echo $avis_item['note']; ?></td>
                    <td><?php echo $avis_item['date_enregistrement']; ?></td>
                    <td>
                        <a href="edit_avis.php?id=<?php echo $avis_item['id_avis']; ?>" class="btn btn-warning">Modifier</a>
                        <a href="delete_avis.php?id=<?php echo $avis_item['id_avis']; ?>" class="btn btn-danger">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

