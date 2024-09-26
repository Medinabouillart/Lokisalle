<?php
include 'includes/header.php'; // Inclure le header
include 'includes/db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

// Récupérer l'ID de la salle depuis l'URL
$id_salle = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_salle) {
    // Si l'utilisateur a déjà réservé la salle
    $query = "SELECT * FROM reservations WHERE id_utilisateur = :id_utilisateur AND id_salle = :id_salle";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_utilisateur', $_SESSION['user_id']);
    $stmt->bindParam(':id_salle', $id_salle);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reservation) {
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $note = $_POST['note'];
            $commentaire = $_POST['commentaire'];

            // Insertion de l'avis dans la base de données
            $query = "INSERT INTO avis (id_salle, id_utilisateur, note, commentaire) 
                      VALUES (:id_salle, :id_utilisateur, :note, :commentaire)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_salle', $id_salle);
            $stmt->bindParam(':id_utilisateur', $_SESSION['user_id']);
            $stmt->bindParam(':note', $note);
            $stmt->bindParam(':commentaire', $commentaire);

            if ($stmt->execute()) {
                echo "<p>Merci pour votre avis !</p>";
            } else {
                echo "<p>Erreur lors de l'enregistrement de l'avis.</p>";
            }
        }
    } else {
        echo "<p>Vous n'avez jamais réservé cette salle, vous ne pouvez pas la noter.</p>";
    }
} else {
    echo "<p>Salle non trouvée.</p>";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noter la salle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome pour les étoiles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .stars {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            font-size: 2em;
            color: grey;
        }

        .stars input {
            display: none;
        }

        .stars label {
            cursor: pointer;
            color: grey;
        }

        .stars input:checked ~ label,
        .stars label:hover,
        .stars label:hover ~ label {
            color: gold;
        }

        .btn {
            background-color: transparent;
            color: black;
            border: 1px solid black;
            padding: 10px 20px;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Laisser un avis</h2>
    <form method="POST" action="noter.php?id=<?= $id_salle ?>">
        <div class="form-group">
            <label for="note">Note</label>
            <div class="stars">
                <input type="radio" id="star1" name="note" value="1"><label for="star1" class="fas fa-star"></label>
                <input type="radio" id="star2" name="note" value="2"><label for="star2" class="fas fa-star"></label>
                <input type="radio" id="star3" name="note" value="3"><label for="star3" class="fas fa-star"></label>
                <input type="radio" id="star4" name="note" value="4"><label for="star4" class="fas fa-star"></label>
                <input type="radio" id="star5" name="note" value="5"><label for="star5" class="fas fa-star"></label>
            </div>
        </div>
        <div class="form-group">
            <label for="commentaire">Commentaire</label>
            <textarea name="commentaire" id="commentaire" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn">Envoyer</button>
    </form>
</div>

<?php include 'includes/footer.php'; // Inclure le footer ?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>


