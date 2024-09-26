<?php
// Paramètres de connexion à la base de données
$host = 'localhost';       // L'adresse du serveur de base de données
$dbname = 'lokisalle';     // Nom de la base de données que tu veux utiliser
$username = 'root';        // Nom d'utilisateur
$password = '';            // Mot de passe (vide en local)

// Création de la connexion
try {
    // Connexion à la base de données 'lokisalle'
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurer le mode d'erreur PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connexion réussie à la base de données 'lokisalle'";
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit(); // Arrêter le script si la connexion échoue
}

// Requête Top 5 des salles les mieux notées
$query_top_notes = "
    SELECT s.titre, AVG(a.note) AS moyenne_note
    FROM salles s
    JOIN avis a ON s.id_salle = a.id_salle
    GROUP BY s.id_salle
    ORDER BY moyenne_note DESC
    LIMIT 5
";
$stmt_notes = $conn->prepare($query_top_notes);
$stmt_notes->execute();
$top_salles_notees = $stmt_notes->fetchAll(PDO::FETCH_ASSOC);

// Requête Top 5 des salles les plus commandées
$query_top_reservations = "
    SELECT s.titre, COUNT(r.id_reservation) AS total_reservations
    FROM salles s
    JOIN reservations r ON s.id_salle = r.id_salle
    GROUP BY s.id_salle
    ORDER BY total_reservations DESC
    LIMIT 5
";
$stmt_reservations = $conn->prepare($query_top_reservations);
$stmt_reservations->execute();
$top_salles_reservees = $stmt_reservations->fetchAll(PDO::FETCH_ASSOC);

// Requête Top 5 des membres qui achètent le plus (en termes de quantité)
$query_top_membres_quantite = "
    SELECT u.pseudo, COUNT(r.id_reservation) AS total_reservations
    FROM utilisateurs u
    JOIN reservations r ON u.id = r.id_utilisateur
    GROUP BY u.id
    ORDER BY total_reservations DESC
    LIMIT 5
";
$stmt_membres_quantite = $conn->prepare($query_top_membres_quantite);
$stmt_membres_quantite->execute();
$top_membres_quantite = $stmt_membres_quantite->fetchAll(PDO::FETCH_ASSOC);

// Requête Top 5 des membres qui dépensent le plus cher (en termes de prix total)
$query_top_membres_prix = "
    SELECT u.pseudo, SUM(r.prix_total) AS total_depense
    FROM utilisateurs u
    JOIN reservations r ON u.id = r.id_utilisateur
    GROUP BY u.id
    ORDER BY total_depense DESC
    LIMIT 5
";
$stmt_membres_prix = $conn->prepare($query_top_membres_prix);
$stmt_membres_prix->execute();
$top_membres_prix = $stmt_membres_prix->fetchAll(PDO::FETCH_ASSOC);
?>
