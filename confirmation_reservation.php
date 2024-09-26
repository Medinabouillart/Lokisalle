<?php
include 'includes/header.php'; // Inclure le header
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation Confirmée</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Playfair Display', serif;
            background-color: #f8f9fa;
            color: black;
        }

        .container {
            margin-top: 50px;
            max-width: 800px;
            text-align: center;
        }

        .btn {
            background-color: transparent;
            color: black;
            border: 1px solid black;
            transition: all 0.3s ease;
            padding: 10px 20px;
            font-size: 1.1em;
            margin-top: 20px;
            margin-bottom: 40px; /* Marge pour espacer le bouton du footer */
        }

        .btn:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Réservation confirmée !</h2>
    <p>Merci d'avoir réservé avec nous. Votre réservation a été prise en compte.</p>
    <a href="index.php" class="btn">Retour à l'accueil</a>
</div>

<?php
include 'includes/footer.php'; // Inclure le footer
?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

