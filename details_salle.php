<?php
include 'includes/header.php'; // Inclure le header
include 'includes/db.php'; // Connexion à la base de données

// Récupérer l'ID de la salle à partir de l'URL
if (isset($_GET['id'])) {
    $id_salle = $_GET['id'];

    // Préparer la requête pour obtenir les détails de la salle
    $query = "SELECT * FROM salles WHERE id_salle = :id_salle";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_salle', $id_salle);
    $stmt->execute();
    $salle = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($salle) {
        // Texte supplémentaire unique pour chaque salle
        $texte_supplementaire = '';
        if ($salle['titre'] == 'Créative Boost') {
            $texte_supplementaire = 'Salle idéale pour des séances de brainstorming intenses avec tout le confort nécessaire.';
        } elseif ($salle['titre'] == 'Executive Lounge') {
            $texte_supplementaire = 'Parfait pour des réunions haut de gamme, cette salle offre un service de voiturier et une assistance sur place.';
        } elseif ($salle['titre'] == 'Focus Pro') {
            $texte_supplementaire = 'Salle minimaliste conçue pour maximiser la productivité lors de vos réunions.';
        } elseif ($salle['titre'] == 'Pitch & Présentation') {
            $texte_supplementaire = 'Salle high-tech avec un équipement vidéo professionnel, parfaite pour vos présentations.';
        } elseif ($salle['titre'] == 'Zen & Work') {
            $texte_supplementaire = 'Un espace zen avec des options de massage et de thé pour une ambiance de travail détendue.';
        } elseif ($salle['titre'] == 'Remote Work Hub') {
            $texte_supplementaire = 'Idéale pour le télétravail, cette salle dispose de cabines privées pour un environnement calme et efficace.';
        } elseif ($salle['titre'] == 'Étudiants Pro') {
            $texte_supplementaire = 'Salle à bas prix pour étudiants avec accès à des ressources éducatives et du Wi-Fi gratuit.';
        } elseif ($salle['titre'] == 'Planète Verte') {
            $texte_supplementaire = 'Salle écoresponsable, avec des matériaux durables et des bénéfices reversés à une association pour la planète.';
        }

        // Afficher les informations de la salle
        echo "<div class='container'>";
        echo "<div class='title-section'><h1 class='salle-title'>" . $salle['titre'] . "</h1></div>";
        echo "<div class='details-section'>";
        echo "<img src='/lokisalle/images/" . $salle['photo'] . "' class='img-fluid salle-image' alt='" . $salle['titre'] . "'>";
        echo "<div class='buttons-section'>";

        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            echo '<a href="reservation.php?id=' . $salle['id_salle'] . '" class="btn btn-dark">Réserver</a>';
            echo '<a href="noter.php?id=' . $salle['id_salle'] . '" class="btn btn-dark ml-2">Noter</a>';
        } else {
            echo '<button class="btn btn-dark" disabled>Réserver</button>';
            echo '<p class="text-warning mt-2">Vous devez être connecté pour réserver cette salle.</p>';
            echo '<button class="btn btn-dark ml-2" disabled>Noter</button>';
            echo '<p class="text-warning mt-2">Vous devez être connecté pour noter cette salle.</p>';
        }

        echo "</div>";
        echo "</div>"; // Fin details-section
        echo "<div class='salle-info'>";
        echo "<p><strong>Ville: </strong>" . $salle['ville'] . "</p>";
        echo "<p><strong>Capacité: </strong>" . $salle['capacite'] . " personnes</p>";
        echo "<p><strong>Prix: </strong>" . $salle['prix'] . " €</p>";
        echo "<p><strong>Description: </strong>" . $salle['description'] . "</p>";
        echo "<p><strong>Détails supplémentaires: </strong>" . $texte_supplementaire . "</p>";
        echo "</div>"; // Fin salle-info
        echo "</div>"; // Fin container
    } else {
        echo "<p>Salle non trouvée.</p>";
    }
} else {
    echo "<p>Paramètre invalide.</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la salle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .title-section {
            background-color: black;
            color: white;
            text-align: center;
            padding: 15px;
        }

        .salle-title {
            font-family: 'Playfair Display', serif;
            font-size: 2em;
        }

        .salle-image {
            width: 100%;
            height: auto;
            margin-top: 20px;
        }

        .buttons-section {
            margin-top: 20px;
            text-align: right;
        }

        .salle-info {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .salle-info p {
            font-size: 1.2em;
            color: #333;
        }

        .btn {
            padding: 10px 20px;
            background-color: transparent;
            color: black;
            border: 1px solid black;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>

<?php include 'includes/footer.php'; // Inclure le footer ?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
