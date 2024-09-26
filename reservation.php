<?php
include 'includes/header.php'; // Inclure le header
include 'includes/db.php'; // Connexion à la base de données

// Récupérer l'ID de la salle depuis l'URL
$id_salle = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_salle) {
    // Récupérer les informations de la salle depuis la base de données
    $query = "SELECT * FROM salles WHERE id_salle = :id_salle";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_salle', $id_salle, PDO::PARAM_INT);
    $stmt->execute();
    $salle = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokisalle - Réservation</title>
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
        }

        .btn {
            background-color: transparent;
            color: black;
            border: 1px solid black;
            transition: all 0.3s ease;
            padding: 10px 20px;
            font-size: 1.1em;
        }

        .btn:hover {
            background-color: black;
            color: white;
        }

        .card {
            background-color: #fff;
            color: black;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .total-price {
            font-size: 1.5em;
            font-weight: bold;
        }

        .price-detail {
            font-size: 1.2em;
        }

        .form-control {
            border-radius: 0;
            padding: 10px;
        }
    </style>
    <script>
        function calculerPrix() {
            var prixJour = <?= $salle['prix']; ?>;
            var dateArrivee = new Date(document.getElementById('date_arrivee').value);
            var dateDepart = new Date(document.getElementById('date_depart').value);

            if (dateArrivee && dateDepart && dateArrivee < dateDepart) {
                var diffTime = Math.abs(dateDepart - dateArrivee);
                var jours = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Convertir en jours

                var prixTotal = prixJour * jours;
                var tva = prixTotal * 0.20;
                var prixAvecTva = prixTotal + tva;

                document.getElementById('prix_total').textContent = "Prix total (TVA incluse) : " + prixAvecTva.toFixed(2) + " €";
            } else {
                document.getElementById('prix_total').textContent = "Sélectionnez des dates valides.";
            }
        }
    </script>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2><?php echo $salle['titre']; ?></h2>
        </div>
        <div class="card-body">
            <p><?php echo $salle['description']; ?></p>
            <p><strong>Prix par jour: </strong><?php echo $salle['prix']; ?> €</p>
            
            <!-- Affichage du prix total -->
            <p id="prix_total">Sélectionnez des dates valides.</p>
            
            <form method="POST" action="process_reservation.php" oninput="calculerPrix()">
                <input type="hidden" name="id_salle" value="<?php echo $salle['id_salle']; ?>">
                <div class="form-group">
                    <label for="date_arrivee">Date d'arrivée</label>
                    <input type="date" name="date_arrivee" id="date_arrivee" class="form-control" required onchange="calculerPrix()">
                </div>
                <div class="form-group">
                    <label for="date_depart">Date de départ</label>
                    <input type="date" name="date_depart" id="date_depart" class="form-control" required onchange="calculerPrix()">
                </div>
                <button type="submit" class="btn">Réserver</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; // Inclure le footer ?>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>






