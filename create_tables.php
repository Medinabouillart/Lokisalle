<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'includes/db.php'; // Inclure la connexion à la base de données

try {
    // Requête pour créer la table 'salles'
    $sql = "
    CREATE TABLE IF NOT EXISTS salles (
        id_salle INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(200) NOT NULL,
        description TEXT NOT NULL,
        photo VARCHAR(200),
        pays VARCHAR(20),
        ville VARCHAR(20),
        adresse VARCHAR(50),
        cp INT(5),
        capacite INT(3),
        categorie ENUM('réunion', 'bureau', 'formation') NOT NULL
    );

    CREATE TABLE IF NOT EXISTS produits (
        id_produit INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_salle INT(3) UNSIGNED NOT NULL,
        date_arrivee DATETIME NOT NULL,
        date_depart DATETIME NOT NULL,
        prix INT(3) NOT NULL,
        etat ENUM('libre', 'reservation') NOT NULL,
        FOREIGN KEY (id_salle) REFERENCES salles(id_salle) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS membres (
        id_membre INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        pseudo VARCHAR(20) NOT NULL,
        mdp VARCHAR(60) NOT NULL,
        nom VARCHAR(20),
        prenom VARCHAR(20),
        email VARCHAR(50) NOT NULL,
        civilite ENUM('m', 'f'),
        statut INT(1),
        date_enregistrement DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS avis (
        id_avis INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_membre INT(3) UNSIGNED NOT NULL,
        id_salle INT(3) UNSIGNED NOT NULL,
        commentaire TEXT,
        note INT(2),
        date_enregistrement DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_membre) REFERENCES membres(id_membre) ON DELETE CASCADE,
        FOREIGN KEY (id_salle) REFERENCES salles(id_salle) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS commandes (
        id_commande INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_membre INT(3) UNSIGNED NOT NULL,
        id_produit INT(3) UNSIGNED NOT NULL,
        date_enregistrement DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_membre) REFERENCES membres(id_membre) ON DELETE CASCADE,
        FOREIGN KEY (id_produit) REFERENCES produits(id_produit) ON DELETE CASCADE
    );
    ";

    // Exécution des requêtes SQL
    $conn->exec($sql);
    echo "Tables créées avec succès !";
    
} catch(PDOException $e) {
    echo "Erreur lors de la création des tables : " . $e->getMessage();
}

// Fermer la connexion
$conn = null;
?>