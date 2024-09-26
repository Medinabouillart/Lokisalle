<?php
include 'includes/header.php'; // Inclure le header
include 'includes/db.php'; // Connexion à la base de données

// Récupérer les valeurs des filtres
$ville = isset($_GET['ville']) ? $_GET['ville'] : '';
$prix_max = isset($_GET['prix_max']) ? $_GET['prix_max'] : 1000;
$capacite = isset($_GET['capacite']) ? $_GET['capacite'] : 1;
$date_arrivee = isset($_GET['date_arrivee']) ? $_GET['date_arrivee'] : '';
$date_depart = isset($_GET['date_depart']) ? $_GET['date_depart'] : '';

// Construire la requête SQL de base
$query = "SELECT * FROM salles WHERE 1=1";

// Appliquer les filtres si présents
if (!empty($ville)) {
    $query .= " AND ville = :ville";
}
if (!empty($prix_max)) {
    $query .= " AND prix <= :prix_max";
}
if (!empty($capacite)) {
    $query .= " AND capacite >= :capacite";
}

// Filtrer par date de disponibilité
if (!empty($date_arrivee) && !empty($date_depart)) {
    $query .= " AND id_salle NOT IN (
        SELECT id_salle FROM reservations 
        WHERE (date_debut <= :date_depart AND date_fin >= :date_arrivee)
    )";
}

$stmt = $conn->prepare($query);

// Lier les valeurs des filtres si présents
if (!empty($ville)) {
    $stmt->bindParam(':ville', $ville);
}
if (!empty($prix_max)) {
    $stmt->bindParam(':prix_max', $prix_max);
}
if (!empty($capacite)) {
    $stmt->bindParam(':capacite', $capacite);
}
if (!empty($date_arrivee) && !empty($date_depart)) {
    $stmt->bindParam(':date_arrivee', $date_arrivee);
    $stmt->bindParam(':date_depart', $date_depart);
}

$stmt->execute();
$salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokisalle - Salles</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            color: black;
        }

        .filter-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .salles-section {
            flex: 4;
        }

        .card {
            min-height: 400px;
            text-align: center;
            background-color: #fff;
            color: black;
            height: 100%;
            margin: 10px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre autour des cartes */
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Effet au survol */
        }

        .card img {
            height: 230px;
            width: 100%;
            object-fit: cover;
        }

        .container {
            margin-top: 20px;
            padding-left: 5px;
            padding-right: 5px;
            max-width: 1400px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        /* Bouton avec le style habituel */
        .btn {
            background-color: transparent;
            color: black;
            border: 1px solid black;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: black;
            color: white;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 1.5em;
        }

        .card-text {
            margin-bottom: 10px;
        }

        .row {
            justify-content: space-between;
        }

        .col-md-4 {
            display: flex;
            flex-direction: column;
        }

        .form-inline .form-group {
            margin-bottom: 15px;
        }

        .form-inline .form-group label {
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="filter-section col-12">
            <form method="GET" action="salles.php" class="form-inline">
                <div class="form-group mr-2">
                    <label for="ville" class="mr-2">Ville</label>
                    <select class="form-control" id="ville" name="ville">
                        <option value="">Toutes les villes</option>
                        <option value="Paris">Paris</option>
                        <option value="Lyon">Lyon</option>
                        <option value="Marseille">Marseille</option>
                        <option value="Bordeaux">Bordeaux</option>
                        <option value="Nantes">Nantes</option>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <label for="prix_max" class="mr-2">Prix max</label>
                    <input type="range" class="form-control-range" id="prix_max" name="prix_max" min="0" max="2000" step="50" value="<?= isset($_GET['prix_max']) ? $_GET['prix_max'] : 1000; ?>" oninput="this.nextElementSibling.value = this.value + ' €'">
                    <output>2000 €</output>
                </div>
                <div class="form-group mr-2">
                    <label for="capacite" class="mr-2">Capacité min</label>
                    <input type="number" class="form-control" id="capacite" name="capacite" min="1" value="<?= isset($_GET['capacite']) ? $_GET['capacite'] : 1; ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="date_arrivee" class="mr-2">Arrivée</label>
                    <input type="date" class="form-control" id="date_arrivee" name="date_arrivee" value="<?= isset($_GET['date_arrivee']) ? $_GET['date_arrivee'] : ''; ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="date_depart" class="mr-2">Départ</label>
                    <input type="date" class="form-control" id="date_depart" name="date_depart" value="<?= isset($_GET['date_depart']) ? $_GET['date_depart'] : ''; ?>">
                </div>
                <button type="submit" class="btn">Appliquer</button> <!-- Style de bouton mis à jour -->
            </form>
        </div>
    </div>

    <div class="row salles-section">
        <!-- Cartes des salles générées ici -->
        <div class="col-md-12">
            <div class="row">
                <!-- Boucle PHP ici pour afficher les salles -->
                <?php
                if (!empty($salles)) {
                    foreach ($salles as $salle) { ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="/lokisalle/images/<?php echo $salle['photo']; ?>" class="card-img-top" alt="<?php echo $salle['titre']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $salle['titre']; ?></h5>
                                    <p class="card-text"><?php echo $salle['description']; ?></p>
                                    <p><strong>Prix: </strong><?php echo $salle['prix']; ?> €</p>
                                    <p><strong>Capacité: </strong><?php echo $salle['capacite']; ?> personnes</p>
                                    <p><strong>Ville: </strong><?php echo $salle['ville']; ?></p>
                                    <a href="details_salle.php?id=<?php echo $salle['id_salle']; ?>" class="btn">Plus d'infos</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo "<p>Aucune salle n'est disponible pour ces critères.</p>";
                }
                ?>
            </div>
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

