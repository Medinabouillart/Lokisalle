<?php
include 'includes/db.php'; // Connexion à la base de données

try {
    // Insertion des salles dans la table 'salles' avec les images en .jpg et sans la salle de gaming
    $sql = "INSERT INTO salles (titre, description, photo, pays, ville, adresse, cp, capacite, categorie) VALUES
        ('Executive Lounge', 'Salle haut de gamme avec service de voiturier et chef privé, idéale pour des réunions d\'affaires importantes.', 'executive_lounge.jpg', 'France', 'Paris', '1 Avenue Montaigne', 75008, 10, 'réunion'),
        ('Créative Boost', 'Salle dédiée au brainstorming avec café à volonté et espace de détente à proximité.', 'creative_boost.jpg', 'France', 'Paris', '23 Rue de la Créativité', 75011, 15, 'réunion'),
        ('Focus Pro', 'Salle minimaliste pour des réunions ultra concentrées, avec accès à une salle de sport à proximité.', 'focus_pro.jpg', 'France', 'Lyon', '5 Place Bellecour', 69002, 12, 'réunion'),
        ('Pitch & Présentation', 'Salle high-tech pour des présentations professionnelles avec assistance technique vidéo incluse.', 'pitch_presentation.jpg', 'France', 'Marseille', '10 Quai des Belges', 13001, 20, 'réunion'),
        ('Zen & Work', 'Salle avec ambiance zen, thé vert bio à disposition, et options de massages sur place.', 'zen_work.jpg', 'France', 'Bordeaux', '15 Rue de la Paix', 33000, 8, 'réunion'),
        ('Remote Work Hub', 'Espace conçu pour le télétravail avec cabines privées et petit-déjeuner inclus.', 'remote_work_hub.jpg', 'France', 'Nantes', '22 Rue de l\'Atlantique', 44000, 25, 'bureau'),
        ('Étudiants Pro', 'Salle à bas prix pour étudiants avec accès à des ressources éducatives et Wi-Fi gratuit.', 'etudiants_pro.jpg', 'France', 'Lyon', '10 Rue des Écoles', 69007, 30, 'formation'),
        ('Planète Verte', 'Salle écoresponsable, avec des matériaux durables et les bénéfices reversés à une association pour la planète.', 'planete_verte.jpg', 'France', 'Paris', '8 Rue des Plantes', 75014, 20, 'réunion'),
        ('Influenceurs Studio', 'Studio avec fond vert, équipement vidéo professionnel en option et coin maquillage.', 'influenceurs_studio.jpg', 'France', 'Marseille', '18 Rue des Arts', 13006, 5, 'réunion')";

    // Exécution de la requête
    $conn->exec($sql);
    echo "Salles insérées avec succès dans la table 'salles' !";

} catch(PDOException $e) {
    echo "Erreur lors de l'insertion des données : " . $e->getMessage();
}

$conn = null; // Fermer la connexion
?>