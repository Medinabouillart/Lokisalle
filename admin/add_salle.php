<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../connexion.php"); // Redirection si non connecté ou non admin
    exit();
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les valeurs du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $capacite = $_POST['capacite'];
    $ville = $_POST['ville'];

    // Vérifier si une photo a été téléchargée
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_dest = '../images/' . $photo;

        // Déplacer la photo dans le dossier des images
        if (move_uploaded_file($photo_tmp, $photo_dest)) {
            // Insérer la nouvelle salle dans la base de données
            $sql = "INSERT INTO salles (titre, description, prix, capacite, ville, photo) 
                    VALUES (:titre, :description, :prix, :capacite, :ville, :photo)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':capacite', $capacite);
            $stmt->bindParam(':ville', $ville);
            $stmt->bindParam(':photo', $photo);

            if ($stmt->execute()) {
                $success_message = "Salle ajoutée avec succès.";
            } else {
                $error_message = "Erreur lors de l'ajout de la salle.";
            }
        } else {
            $error_message = "Erreur lors du téléchargement de l'image.";
        }
    } else {
        $error_message = "Veuillez choisir une image pour la salle.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Salle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Ajouter une Salle</h1>
    
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre de la salle</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="prix">Prix par jour (€)</label>
            <input type="number" name="prix" id="prix" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="capacite">Capacité (nombre de personnes)</label>
            <input type="number" name="capacite" id="capacite" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" name="ville" id="ville" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="photo">Photo de la salle</label>
            <input type="file" name="photo" id="photo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-dark">Ajouter la salle</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
