<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../connexion.php"); // Redirection si non connecté ou non admin
    exit();
}

// Récupérer l'ID de la salle à partir de l'URL
if (!isset($_GET['id'])) {
    header("Location: manage_salles.php");
    exit();
}

$id_salle = $_GET['id'];

// Récupérer les informations de la salle à partir de la base de données
$sql = "SELECT * FROM salles WHERE id_salle = :id_salle";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_salle', $id_salle);
$stmt->execute();
$salle = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$salle) {
    echo "Salle non trouvée.";
    exit();
}

// Traitement du formulaire lorsque les modifications sont soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $ville = $_POST['ville'];
    $capacite = $_POST['capacite'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];

    // Mettre à jour les informations de la salle dans la base de données
    $sql_update = "UPDATE salles SET titre = :titre, ville = :ville, capacite = :capacite, prix = :prix, description = :description WHERE id_salle = :id_salle";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(':titre', $titre);
    $stmt_update->bindParam(':ville', $ville);
    $stmt_update->bindParam(':capacite', $capacite);
    $stmt_update->bindParam(':prix', $prix);
    $stmt_update->bindParam(':description', $description);
    $stmt_update->bindParam(':id_salle', $id_salle);

    if ($stmt_update->execute()) {
        // Redirection après mise à jour réussie
        header("Location: manage_salles.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la salle.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Salle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Modifier la Salle</h1>

    <form method="POST" class="mt-4">
        <div class="form-group">
            <label for="titre">Titre de la salle</label>
            <input type="text" name="titre" id="titre" class="form-control" value="<?php echo htmlspecialchars($salle['titre']); ?>" required>
        </div>

        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" name="ville" id="ville" class="form-control" value="<?php echo htmlspecialchars($salle['ville']); ?>" required>
        </div>

        <div class="form-group">
            <label for="capacite">Capacité</label>
            <input type="number" name="capacite" id="capacite" class="form-control" value="<?php echo $salle['capacite']; ?>" required>
        </div>

        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="number" name="prix" id="prix" class="form-control" value="<?php echo $salle['prix']; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required><?php echo htmlspecialchars($salle['description']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-dark">Enregistrer les modifications</button>
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
