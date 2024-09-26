<?php
// Inclure le fichier header.php
include 'includes/header.php'; // Assurez-vous que le chemin est correct
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Lokisalle</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <!-- Carrousel Bootstrap avec défilement automatique -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/remote_work_hub_carousel.jpg" class="d-block w-100" alt="Remote Work Hub">
            <div class="carousel-caption d-none d-md-block">
                <h5>Salle 1 - Remote Work Hub</h5>
                <p>Un espace moderne équipé pour le télétravail, avec toutes les commodités nécessaires pour booster votre productivité.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="images/etudiants_pro_carousel.jpg" class="d-block w-100" alt="Étudiants Pro">
            <div class="carousel-caption d-none d-md-block">
                <h5>Salle 2 - Étudiants Pro</h5>
                <p>Une salle abordable conçue pour les étudiants avec des installations pratiques pour les présentations et projets en groupe.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="images/planete_verte_carousel.jpg" class="d-block w-100" alt="Planète Verte">
            <div class="carousel-caption d-none d-md-block">
                <h5>Salle 3 - Planète Verte</h5>
                <p>Un espace écoresponsable conçu à partir de matériaux recyclés, avec une partie des bénéfices reversés à des associations environnementales.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Précédent</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Suivant</span>
    </a>
</div>
    <!-- Section Bannière ou Introduction -->
    <section class="hero">
        <div class="hero-text">
            <h1>Bienvenue sur Lokisalle</h1>
            <p>Découvrez nos salles uniques pour vos réunions, événements, et plus encore.</p>
            <a href="salles.php" class="btn btn-primary">Voir nos salles</a>
        </div>
    </section>

<!-- Story telling -->
<section class="story-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Image qui flotte à gauche -->
                <img src="images/equipe.jpg" alt="Notre équipe" class="img-fluid float-left mr-4 mb-3" style="width: 350px;">

                <h2>Notre Histoire</h2>
                <p>
                    <strong>LOKISALLE</strong> est née d’une conviction simple : les espaces de réunion et d'événements doivent être plus que de simples lieux. 
                    Ils doivent être des espaces de connexion, de créativité et de transformation.
                </p>
                <p>
                    Fondée par des passionnés d’événements et de développement durable, notre entreprise s'est donnée pour mission de créer des salles accessibles, 
                    accueillantes, et écoresponsables. Chaque espace que nous proposons est conçu pour inspirer et soutenir les professionnels, les étudiants, 
                    et les créateurs de demain.
                </p>
                <p>
                    Nous croyons fermement en l'impact positif que nous pouvons avoir sur notre société et notre planète. C’est pourquoi nous avons intégré des 
                    pratiques écoresponsables dans tout ce que nous faisons, de l'utilisation de matériaux durables dans la conception de nos salles à notre salle 
                    <strong>Planète Verte</strong>, où chaque réservation contribue à des initiatives environnementales locales.
                </p>
                <p>
                    Chez <strong>LOKISALLE</strong>, nous avons également un engagement social fort. Nous nous efforçons de rendre nos espaces accessibles à tous, 
                    avec des offres spéciales pour les étudiants et des tarifs solidaires pour les projets à but non lucratif.
                </p>
            </div>
        </div>
    </div>
</section>

  <!-- Section carte avec l'adresse -->
  <section class="map-section">
        <h2 class="text-center">Où nous trouver</h2>
        <div class="map-container">
            <!-- Intégration Google Maps avec l'adresse réelle -->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.3488209116826!2d2.298217815673878!3d48.837265979285695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6702b1414f4e9%3A0xb123456789abcde!2s300%20Boulevard%20de%20Vaugirard%2C%2075015%20Paris%2C%20France!5e0!3m2!1sfr!2sfr!4v1618270000000!5m2!1sfr!2sfr"
                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>

        <!-- Coordonnées et horaires en colonnes -->
        <div class="info-columns">
            <!-- Colonne 1 : Coordonnées -->
            <div class="contact-info">
                <h3>Coordonnées</h3>
                <p>Raison sociale : LOKISALLE</p>
                <p>Adresse : 300 Boulevard de Vaugirard, 75015 Paris, France</p>
                <p>Téléphone : 01 23 45 67 89</p>
                <p>Email : contact@lokisalle.com</p>
            </div>

            <!-- Colonne 2 : Horaires d'ouverture -->
            <div class="opening-hours">
                <h3>Horaires d'ouverture</h3>
                <p>Lundi - Vendredi : 09h00 - 18h00</p>
                <p>Samedi : 10h00 - 14h00</p>
                <p>Dimanche : Fermé</p>
            </div>
        </div>
    </section>

</body>
</html>

<?php include 'includes/footer.php'; ?>
